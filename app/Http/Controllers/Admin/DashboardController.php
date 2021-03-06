<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\ShopStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\BackendController;
use App\Models\Order;
use App\Models\Shop;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Tableau de bord';
        $this->middleware([ 'permission:dashboard' ])->only('index');
    }

    public function index()
    {
        $this->data['months'] = [
            1 => 'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
        if(auth()->user()->myrole == 3){
          $orders = Order::orderBy('id', 'desc')->where('shop_id', auth()->user()->shop->id)->orderOwner();
          $income = Order::where('status', 20)->where('shop_id', auth()->user()->shop->id)->sum('total');
          $vendor_orders = Order::where('shop_id', auth()->user()->shop->id)->get()->count();
          $vendor_orders_complete = Order::where('shop_id', auth()->user()->shop->id)->where('status', 20)->count();
            $this->data['vendorincome']  = $income;
            $this->data['vendororders']  = $vendor_orders;
            $this->data['vendor_orders_complete']  = $vendor_orders_complete;
        }else{
          $orders = Order::orderBy('id', 'desc')->orderOwner();
        }
        $totalOrders  = $orders->get();
        $recentOrders = Order::orderBy('id', 'desc')->whereDate('created_at', date('Y-m-d'))->orderOwner()->get();
        $totalIncome = Order::where('status', 20)->sum('total');
        /*if ( !blank($totalOrders) ) {
            foreach ( $totalOrders as $totalOrder ) {
                if ( OrderStatus::COMPLETED == $totalOrder->status ) {
                    $totalIncome += $totalOrder->paid_amount;
                }
            }
        }*/

        $this->data['totalOrders'] = $totalOrders;
        $this->data['totalIncome'] = $totalIncome;
        if ( auth()->user()->myrole == UserRole::ADMIN ) {
            $role = Role::find(2);
            $this->data['totalUsers'] = User::role($role->name)->where([ 'status' => UserStatus::ACTIVE ])->get();
            $this->data['totalShops'] = Shop::where([ 'status' => ShopStatus::ACTIVE ])->get();
        } elseif ( auth()->user()->myrole == UserRole::SHOPOWNER || auth()->user()->myrole == UserRole::DELIVERYBOY ) {
            if ( auth()->user()->myrole == UserRole::SHOPOWNER ) {
                $this->data['totalPendingOrders'] = $orders->pending()->get();
            }
            $this->data['totalProcessOrders']  = $orders->process()->get();
            $this->data['totalCompleteOrders'] = $orders->complete()->get();
        }
        $this->data['recentOrders'] = $recentOrders;
        return view('admin.dashboard.index', $this->data);
    }

    public function dayWiseIncomeOrder( Request $request )
    {
        $type          = $request->type;
        $monthID       = $request->monthID;
        $dayWiseData   = $request->dayWiseData;
        $showChartData = [];
        if ( $type && $monthID ) {
            $days        = date('t', mktime(0, 0, 0, $monthID, 1, date('Y')));
            $dayWiseData = json_decode($dayWiseData, true);
            for ( $i = 1; $i <= $days; $i++ ) {
                $showChartData[ $i ] = isset($dayWiseData[ $i ]) ? $dayWiseData[ $i ] : 0;
            }
        } else {
            for ( $i = 1; $i <= 31; $i++ ) {
                $showChartData[ $i ] = 0;
            }
        }
        echo json_encode($showChartData);
    }

}
