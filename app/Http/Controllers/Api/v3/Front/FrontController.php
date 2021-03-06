<?php

namespace App\Http\Controllers\Api\v3\Front;

use App\Enums\Status;
use App\Favourite;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\CategoryCollection;
use App\Http\Resources\v2\CountryCollection;
use App\Http\Resources\v2\ProductCollection;
use App\Http\Resources\v2\SettingCollection;
use App\Http\Resources\v2\VipCategoryColection;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Location;
use App\Models\ShopProduct;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JamesMills\LaravelTimezone\Facades\Timezone;

class FrontController extends Controller
{
    public function productCategory($id){
        $category = Category::latest()->where('status', '!=', 10)->where('is_vip', 'Non')->where('country_id', $id??1)->get();
        $data = CategoryCollection::collection($category);
        return response()->json($data,200);
    }
    public function vipProductCategory($id){
        $category = SubCategory::where('location_id', $id??1)->get();
        $data = VipCategoryColection::collection($category);
        return response()->json($data,200);
    }
    public function webSetting($id){
        $setting = Banner::where(['status' => Status::ACTIVE])->orderBy('sort', 'asc')->where('country_id', $id??1)->get();
        $data = SettingCollection::collection($setting);
        return response()->json($data,200);
    }
    public function location(){
        $location = Location::all();
        $data = CountryCollection::collection($location);
        return response()->json($data,200);
    }
    public function allProduct($id){
        $category = Category::latest()->where('status', '!=', 10)->where('is_vip', 'Non')->where('country_id', $id??1)->pluck('id');
        $productIds = CategoryProduct::whereIn('category_id', $category)->pluck('product_id');
        $shopProduct = ShopProduct::whereIn('product_id', $productIds)->where('quantity', '>', 0)->whereHas('product', function($q) {
            $q->where('publish', '<=', Timezone::convertToLocal(Carbon::today(), 'Y-m-d'));
        })->get();
        $data = ProductCollection::collection($shopProduct);
        return response()->json($data,200);
    }
}
