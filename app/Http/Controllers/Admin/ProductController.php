<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductRequested;
use App\Enums\ProductStatus;
use App\Enums\Status;
use App\Favourite;
use App\Http\Controllers\BackendController;
use App\Http\NotificationHelper;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use Jenssegers\Date\Date;
Date::setLocale('fr');
class ProductController extends BackendController
{

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Paniers';
        $this->middleware(['permission:products'])->only('index');
        $this->middleware(['permission:products_create'])->only('create', 'store');
        $this->middleware(['permission:products_edit'])->only('edit', 'update');
        $this->middleware(['permission:products_delete'])->only('destroy');
        $this->middleware(['permission:products_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->myrole == 1) {
          $this->data['shops_list'] = Shop::all();
        }
        $this->data['locations'] = Location::where(['status' => Status::ACTIVE])->get();

        $this->data['categories'] = Category::where(['status' => Status::ACTIVE])->get();
        return view('admin.product.create', $this->data);
    }

    /**
     * @param ProductRequest $request
     * @return mixed
     */
    public function store(ProductRequest $request)
    {
        $user = auth()->user();
      if (auth()->user()->myrole == 3) {
        $shopID = $user->shop->id;
      }else{
        $shopID = $request->get('shop_id');
      }

        $product              = new Product;
        $product->description = $request->get('description');
        $product->unit_price  = $request->get('unit_price');
        $product->subcategories  = $request->subcategory;
        $product->name  = $request->name;
        $product->requested   = ProductRequested::REQUESTED;
        $product->save();
//        dd($product->slug);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $product->addMediaFromRequest('image')->toMediaCollection('products');
        }
        $product->categories()->sync($request->get('categories'));
        if($request->get('quantity') != ''){
          $shopProduct                 = new ShopProduct;
          $shopProduct->shop_id        = $shopID;
          $shopProduct->product_id     = $product->id;
          $shopProduct->unit_price     = $request->get('unit_price');
          $shopProduct->quantity       = $request->get('quantity') != null ? $request->get('quantity') : 0;
          $shopProduct->hdispoa        = $request->get('hdispoa');
          $shopProduct->hdispob        = $request->get('hdispob');
          $shopProduct->discount_price = $request->get('discount_price') != null ? $request->get('discount_price') : 0;
          $shopProduct->save();
        }
        $fav = Favourite::where('product_creator', $shopProduct->shop->user->id)->get()->unique('user_id');
        $user_ids = $fav->pluck('user_id');
        $firebaseToken = User::whereIn('id', $user_ids)->where('address', $shopProduct->shop->user->address)->whereNotNull('device_token')->pluck('device_token')->all();

        $activity = "Nouveau panier";
        $msg = "Fais vite, ".$shopProduct->shop->name." vient de rajouter des paniers à sauver 😋";
        $users = User::whereIn('id', $user_ids)->where('address', $shopProduct->shop->user->address)->get();
        foreach ($users as $user){
            NotificationHelper::addtoNitification($shopProduct->shop->user->id, $user->id, $msg, $product->id, $activity, $shopProduct->shop->user->address);
        }

        $SERVER_API_KEY = 'AAAAAjqrxA4:APA91bH2gSA-MK-gvM4ASC7-xfx7Fg--FMCzg1KdZ5wkwQb1fCOkWdDKvLWSHW4dJAwvX9SVjYWVQwHeYxElsi7fuwu3fuidKJzyWI0YlCipcGK5DnTStSmwvDNdCAfMxrYyDcqSRtEm';

        $data = [
            "registration_ids" => $firebaseToken,
            "data" => [
                "title" => "Yummy Box",
                "message" => "Fais vite, ".$shopProduct->shop->name." vient de rajouter des paniers à sauver 😋",
                "click_action" => "NotificationLunchScreen",
            ],
            "notification" => [
                "title" => "Yummy Box",
                "body" => "Fais vite, ".$shopProduct->shop->name." vient de rajouter des paniers à sauver 😋",
                "click_action" => "NotificationLunchScreen",
            ],
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        return redirect()->route('admin.products.index')->withSuccess('Panier ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $this->data['locations'] = Location::where(['status' => Status::ACTIVE])->get();

        $this->data['product']            = $product;
        $this->data['shopproduct']        = ShopProduct::where('product_id','=' ,$product->id)->first();
        //dd($this->data['shopproduct']);
        $this->data['categories']         = Category::where(['status' => Status::ACTIVE])->pluck('name','id')->toArray();
        $this->data['product_categories'] = $product->categories()->pluck('id')->toArray();

        return view('admin.product.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param ProductRequest $request
     * @param $id
     * @return mixed
     */
    public function update(ProductRequest $request, $id)
    {
        if (auth()->user()->myrole == 3) {
          $shopID = auth()->user()->shop->id;
        }else{
          $shopID = $request->get('shop_id');
        }
        $product              = Product::findOrFail($id);
        $product->name        = $request->get('name');
        $product->description = $request->get('description');
        $product->status      = $request->get('status');
        $product->unit_price  = $request->get('unit_price');
        $product->subcategories  = $request->subcategory;
        $product->save();
        $product->categories()->sync($request->get('categories'));
        $affectedRows = ShopProduct::where("product_id", $product->id)->update(["quantity" => $request->get('quantity'), "hdispoa" => $request->get('hdispoa'), "hdispob"=> $request->get('hdispob'), "discount_price"=> $request->get('discount_price')]);

        return back()->withSuccess('Panier mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.products.index')->withSuccess('The Data Deleted Successfully');
    }

    public function getProduct(Request $request)
    {
        if (request()->ajax()) {

            $queryArray = [];
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
            }
            if ($request->requested != '') {
                $queryArray['requested'] = $request->requested;

                $queryArray['shop_products.shop_id'] = auth()->user()->shop->id;
            }

            if (!blank($queryArray)){
                $products = ShopProduct::where($queryArray)->latest()->get();
              }elseif(auth()->user()->myrole == 3){
                $products = ShopProduct::with('product')->where('shop_id', auth()->user()->shop->id)->latest()->get();
              }else{
                $products = ShopProduct::latest()->get();
              }

            $i            = 1;
            $productArray = [];
            if (!blank($products)) {
                foreach ($products as $product) {
                    $productArray[$i]          = $product;
                    $productArray[$i]['setID'] = $i;
                    $i++;
                }
            }
            return Datatables::of($productArray)
                ->addColumn('action', function ($product) {
                    $retAction ='';

                    if(auth()->user()->can('products_edit')) {
                        $retAction .= '<a href="' . route('admin.products.edit', $product->product_id) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a><a href="' . route('admin.product.my.delete', $product->product_id) . '" class="btn btn-sm btn-icon float-left btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="far fa-cross"></i></a>';
                    }
                    return $retAction;
                })
                ->editColumn('name', function ($product) {
                    $col = '<p class="p-0 m-0">' . $product->shop->name . '</p>';
                    $col .= '<small class="text-muted">' . Str::limit($product->product->description, 20) . '</small>';
                    return $col;
                })
                ->editColumn('stock', function ($product) {
                  return $product->quantity;
                })
                ->editColumn('id', function ($product) {
                    return $product->setID;
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json(['name' => $name, 'original_name' => $file->getClientOriginalName()]);
    }


    public function updateMedia(Request $request, Product $product)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);
        $product->addMedia($path.'/'.$name)->toMediaCollection('products');

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteMedia(Request $request)
    {
        $path = storage_path('tmp/uploads/' . $request->filename);
        if ( file_exists($path) ) {
            unlink($path);
        }
    }
    public function mydelete($id){
        $product = ShopProduct::where('product_id', $id)->first();
        $product->delete();
        return redirect()->back();
    }
    public function getMedia( Request $request )
    {
        $product   = Product::find($request->id);
        $addMedias = $product->getMedia('products');
        $retArr    = [];
        if ( count($addMedias) ) {
            $i = 0;
            foreach ( $addMedias as $addMedia ) {
                $i++;
                $retArr[ $i ]['name'] = $addMedia->file_name;
                $retArr[ $i ]['size'] = $addMedia->size;
                $retArr[ $i ]['url']  = asset($addMedia->getUrl());
            }
        }
        echo json_encode($retArr);
    }

    public function removeMedia( Request $request )
    {
        $product = Product::find($request->id);
        $product->deleteMedia($product, $request->media, $request->id);
        return $this->getMedia($request);
    }
}
