<?php

namespace App\Http\Controllers\Api\v3\Front;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\CategoryCollection;
use App\Http\Resources\v2\CountryCollection;
use App\Http\Resources\v2\SettingCollection;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function productCategory($id){
        $category = Category::latest()->where('status', '!=', 10)->where('is_vip', 'Non')->where('country_id', $id??1)->get();
        $data = CategoryCollection::collection($category);
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
}
