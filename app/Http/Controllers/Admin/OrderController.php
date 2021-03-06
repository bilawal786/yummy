<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 19/4/20
 * Time: 10:59 PM
 */

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\ProductReceiveStatus;
use App\Exports\OrderExport;
use App\Exports\TradersExport;
use App\Http\Controllers\BackendController;
use App\Http\Requests\OrderRequest;
use App\Http\Services\OrderService;
use App\Http\Services\PaymentTransactionService;
use App\Models\BestSellingCategory;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderLineItem;
use App\Models\ShopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
class OrderController extends BackendController
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Commandes';

        $this->middleware(['permission:orders'])->only('index');
        $this->middleware(['permission:orders_create'])->only('create', 'store');
        $this->middleware(['permission:orders_edit'])->only('edit', 'update');
        $this->middleware(['permission:orders_delete'])->only('destroy');
        $this->middleware(['permission:orders_show'])->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $orders = Order::orderOwner()->get();
        $orders = Order::orderOwner()->whereDate('created_at', Carbon::today())->get();

        $this->data['orders']     = $orders;
        $this->data['total_order']     = $orders->count();
        $this->data['read_pickup']   = $orders->where('status', 17)->count();
        $this->data['cancelled']   = $orders->where('status', 10)->count();
        $this->data['completed_order'] = $orders->where('status', 20)->count();
        $this->data['recover_revenue'] = $orders->where('status', 20)->sum('sub_total');
        $this->data['cancel_revenue'] = $orders->where('status', 10)->sum('sub_total');

        return view('admin.orders.index', $this->data);
    }
    public function exportorders(){
        return Excel::download(new OrderExport(), 'commandes.xlsx');
    }
    public function orderFetchStatus(Request $request){
        $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
        $end_date = Carbon::parse($request->end_date)
            ->toDateTimeString();
        if ($request->status == 0){
            $orders = Order::orderOwner()->whereBetween('created_at',[$start_date,$end_date])->get();
        }else{
            $orders = Order::orderOwner()->whereBetween('created_at',[$start_date,$end_date])->where('status', $request->status)->get();
        }

        $this->data['orders']     = $orders;
        $this->data['total_order']     = $orders->count();
        $this->data['read_pickup']   = $orders->where('status', 17)->count();
        $this->data['cancelled']   = $orders->where('status', 10)->count();
        $this->data['completed_order'] = $orders->where('status', 20)->count();
        $this->data['recover_revenue'] = $orders->where('status', 20)->sum('sub_total');
        $this->data['cancel_revenue'] = $orders->where('status', 10)->sum('sub_total');

        return view('admin.orders.index', $this->data);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $this->data['order'] = Order::orderOwner()->findOrFail($id);
        $this->data['items'] = OrderLineItem::where(['order_id' => $this->data['order']->id])->get();
        return view('admin.orders.view', $this->data);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delivery($id)
    {
        $this->data['order'] = Order::where('delivery_boy_id', '!=', null)->orderOwner()->findOrFail($id);
        if (blank($this->data['order']->delivery)) {
            return redirect(route('admin.orders.index'))->withError('The delivery boy not found');
        }
        return view('admin.orders.delivery', $this->data);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->data['order'] = Order::findOrFail($id);
        $this->data['items'] = OrderLineItem::where(['order_id' => $this->data['order']->id])->get();

        $this->getOrderStatus($this->data['order']);
        $this->showStatusReceiveForm($this->data['order']);

        return view('admin.orders.edit', $this->data);
    }

    /**
     * @param OrderRequest $request
     * @param $id
     *
     * @return mixed
     */
    public function update(OrderRequest $request, $id)
    {
        $orderService = app(OrderService::class)->orderUpdate($id, $request->status);

        if($orderService->status) {
            return redirect(route('admin.orders.edit', $id))->withSuccess('Order successfully updated');
        } else {
            return redirect(route('admin.orders.edit', $id))->withError($orderService->message);
        }
    }

    /**
     * @param OrderRequest $request
     * @param $id
     *
     * @return mixed
     */
    public function productReceive(Request $request, $id)
    {
        $this->validate($request, ['product_received' => 'required|numeric']);

        $productReceive = app(OrderService::class)->productReceive($id, $request->post('product_received'));

        if($productReceive->status) {
            return redirect(route('admin.orders.show', $id))->withSuccess('The Data Updated Successfully');
        } else {
            return redirect(route('admin.orders.show', $id))->withError($productReceive->message);
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        Order::orderOwner()->findOrFail($id)->delete();
        return redirect(route('admin.orders.index'))->withSuccess('The Data Deleted Successfully');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getOrder(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->status)) {
                $startDate = $request->startDate;
                $endDate   = $request->endDate;
                $orders    = Order::where(['status' => $request->status])->where(function ($query) use (
                    $startDate,
                    $endDate
                ) {
                    if (!blank($startDate)) {
                        $startDate = Carbon::parse($startDate)->startOfDay()->toDateTimeString();
                        $endDate   = Carbon::parse(blank($endDate) ? $startDate : $endDate)->endOfDay()->toDateTimeString();
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }

                })->latest()->orderOwner()->get();
            } else {
                $orders = Order::latest()->orderOwner()->get();
            }

            $i          = 1;
            $orderArray = [];
            if (!blank($orders)) {
                foreach ($orders as $order) {
                    $orderArray[$i]          = $order;
                    $orderArray[$i]['setID'] = $order->order_code;
                    $i++;
                }
            }

            return Datatables::of($orderArray)
                ->addColumn('action', function ($order) {
                    $retAction = '';

                    if (auth()->user()->can('orders_show')) {
                        $retAction .= '<a href="' . route('admin.orders.show',
                            $order) . '" class="btn btn-sm btn-icon btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if (auth()->user()->can('orders_edit') && $order->status != OrderStatus::COMPLETED) {
                        $retAction .= '&nbsp;&nbsp;&nbsp;<a href="' . route('admin.orders.edit', $order) . '" class="pl-2 btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('orders_show') && $order->delivery_boy_id) {
                        $retAction .= '&nbsp;&nbsp;&nbsp;<a href="' . route('admin.orders.delivery', $order) . '" class="btn btn-sm btn-icon btn-success" data-toggle="tooltip" data-placement="top" title="Delivery"><i class="far fa-list-alt"></i></a>';
                    }

                    return $retAction;
                })
                ->editColumn('user_id', function ($order) {
                    return (!blank($order->user) ? Str::limit($order->user->first_name . ' ' . $order->user->last_name,
                        20) : '');
                })
                ->editColumn('created_at', function ($order) {
                    return Carbon::parse($order->created_at)->format('d M Y, H:i');
                })
                ->editColumn('total', function ($order) {
                    return $order->total.'???';
                })
                ->editColumn('status', function ($order) {
                    if ($order->status == 20){
                        return "Vendu";
                    }elseif ($order->status == 10){
                        return "Annuler";
                    }else{
                        return "Pr??t ?? r??cup??rer";
                    }
                })
                ->editColumn('id', function ($order) {
                    return $order->setID;
                })->make(true);
        }
    }

    private function getOrderStatus($order)
    {
        $myRole      = auth()->user()->myrole;
        $allowStatus = [];

        if ($myRole == 2) {
            $allowStatus = [OrderStatus::CANCEL];
        } else if ($myRole == 3) {
            if($order->status == OrderStatus::PENDING) {
                $allowStatus = [OrderStatus::ACCEPT, OrderStatus::REJECT];
            } elseif($order->status == OrderStatus::ACCEPT) {
                $allowStatus = [OrderStatus::PROCESS];
            } elseif($order->status == OrderStatus::REJECT) {
                $allowStatus = [OrderStatus::REJECT];
            }
        } else if ($myRole == 4) {
            $allowStatus = [OrderStatus::ON_THE_WAY, OrderStatus::COMPLETED];
        }

        $orderStatusArray = [];
        if (!blank($allowStatus)) {
            foreach (trans('order_status') as $key => $status) {
                if (in_array($key, $allowStatus)) {
                    $orderStatusArray[$key] = $status;
                }
            }
        }
        $this->data['orderStatusArray'] = $orderStatusArray;
    }

    private function showStatusReceiveForm($order)
    {
        $myrole = auth()->user()->myrole;

        $showStatus = true;
        if ($myrole == 1 || $myrole == 4) {
            $showStatus = false;
        }

        $showReceive = false;
        if (($order->status == 15) && $myrole == 3) {
            $showStatus  = false;
            $showReceive = true;
        }

        if (($order->status == 17) && $myrole == 3) {
            $showStatus = true;
        }

        if (($order->status == 17) && $myrole == 3) {
            $showStatus = false;
        }

        $this->data['showStatus']  = $showStatus;
        $this->data['showReceive'] = $showReceive;
    }

    public function getDownloadFile($id)
    {
        if ( (int)$id ) {
            $order = Order::find($id);
            if ( !blank($order) ) {
                $file = $order->getMedia('orders');
                return $this->fileDownloadResponse($file[0]);
            }
        }
    }
    public function deliverytime(Request $request){
        $order = Order::find($request->id);
        $order->deliverytime = $request->deliverytime;
        $order->update();
        return redirect()->back()->withSuccess('The Data Deleted Successfully');
    }

    public function fetchTraders(Request $request){
        $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
        $end_date = Carbon::parse($request->end_date)
        ->toDateTimeString();
        $orders = Order::where('shop_id', $request->shop_id)->whereBetween('created_at',[$start_date,$end_date])->get();
        return Excel::download(new TradersExport($orders), 'Commandes.xlsx');
    }

    private function fileDownloadResponse(Media $mediaItem)
    {
        return $mediaItem;
    }
}
