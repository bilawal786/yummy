<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Status;
use App\Favourite;
use App\Http\Controllers\FrontendController;
use App\Models\Banner;
use App\Models\BestSellingCategory;
use App\Models\Category;
use App\Models\CategoryShop;
use App\Models\Location;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WebController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Frontend';
    }

    public function index()
    {
        $this->data['banners']   = Banner::where(['status' => Status::ACTIVE])->orderBy('sort', 'asc')->where('country_id', Auth::user()->address)->get();
        $this->data['locations'] = Location::orderBy('name', 'desc')->get();
        $this->data['products']     = Product::with('categories')->inRandomOrder()->get();
        $this->data['proxim']    = Shop::where('vip', '=', '1')->inRandomOrder()->limit(3)->get();
        $this->data['bestSellingShops']      = ShopProduct::with('shop')->selectRaw('shop_products.*, SUM(counter) as qty')->groupBy('shop_id')->orderBy('qty', 'desc')->get()->take(3);
        $this->data['categories']            = Category::pluck('name', 'id');
        $this->data['cat']                   = Category::where('status', '!=', 10)->get();
        $this->data['shopProducts']          = ShopProduct::orderBy('id', 'desc')->limit(3)->with('product')->get();
        $mytime = Carbon::now();
        $this->data['heure'] = $mytime->format('H:i:s');
        $this->data['user'] = auth()->user();
        $this->data['BestSellingCategories'] = BestSellingCategory::orderBy('counter', 'desc')->get()->take(5);
        $this->data['BestSellingProducts']   = ShopProduct::where('counter', '!=', 0)->orderBy('counter', 'desc')->get()->take(10);
        return view('frontend.home-mobile', $this->data);
    }

    public function addtowishlist(Request $request){
        $check_fave = Favourite::where('product_id', $request->id)->where('user_id', Auth::user()->id)->first();
        if ($check_fave){
            return response()->json(['error' => 'Already Added']);
        }else{
            $fav = new Favourite();
            $fav->product_id = $request->id;
            $fav->product_creator = $request->c_id;
            $fav->user_id = Auth::user()->id;
            $fav->save();
            return response()->json(['success' => 'Successfully Added']);
        }

    }

    public function mapshow(){
      $this->data['namepage']  = "Carte";
      $this->data['user'] = auth()->user();
      return view('frontend.map', $this->data);
    }

    public function shopProduct($shopName, $productSlug)
    {
        $this->data['locations'] = Location::orderBy('name', 'desc')->get();
        $shop                    = Shop::where(['slug' => $shopName])->first();
        $product                 = Product::where(['slug' => $productSlug])->first();
        if (!blank($shop) && !blank($product)) {
            $this->data['site_title']  = $product->name;
            $this->data['shopProduct'] = ShopProduct::where(['shop_id' => $shop->id, 'product_id' => $product->id])->first();
            return view('frontend.shop_product', $this->data);
        }
        return abort(404);
    }
    public function map()
    {
        $shop  = Shop::all();
        $geo = [];
        foreach ($shop as $thise) {
          $geo[] = array(
            'type'      => 'Feature',
            'geometry' => [
              'type' => 'Point',
              'coordinates' => [
                $thise->long,
                $thise->lat
                ]
            ],
            'properties'  => $thise,
            'image' => $thise->images,
            'logo' => $thise->logo
            );
        }
        $geojson = array(
               'type'      => 'FeatureCollection',
               'features'  => $geo
            );
        return response()->json($geojson, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }
}
