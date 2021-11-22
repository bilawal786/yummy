<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Models\Area;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Location;
use App\Models\Shop;
use App\Models\ShopProduct;
use App\Models\Product;
use App\Http\Services\RatingsService;
use Carbon\Carbon;

class ShopController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Frontend';

    }

    public function __invoke(Shop $shop)
    {
        $this->data['shop']                = $shop;
        $this->data['products']            = $shop->products()->distinct('product_id')->where('status', "=", 5)->withPivot('id')->latest()->paginate(15);
        $this->data['products_categories'] = CategoryProduct::whereIn('product_id', $this->data['products']->pluck('id'))->get()->pluck('category_id');
        $mytime = Carbon::now();
        $heure = $mytime->format('H:i:s');
        $this->data['user'] = auth()->user();
        $this->data['namepage']  = $this->data['shop']->name;
        //\DB::enableQueryLog();
        $shopProduct = ShopProduct::where(['shop_id' => $shop->id])->where('quantity', '>', 0)->where('hdispoa', '<=', $heure)->where('hdispob', '>=', $heure)->with('product')->get();
        $this->data['shopProduct'] = $shopProduct;
        //dd($shopProduct);
        $this->data['productPrices']         = $shopProduct->pluck('unit_price', 'product_id');
        $this->data['productDiscountPrices'] = $shopProduct->pluck('discount_price', 'product_id');

        $this->data['categories'] = Category::whereIn('id', $this->data['products_categories'])->get();
        $this->data['locations']  = Location::orderBy('name', 'desc')->get();
        $this->data['areas']      = Area::orderBy('name', 'desc')->get();

        return view('frontend.shop-mobile', $this->data);
    }

}
