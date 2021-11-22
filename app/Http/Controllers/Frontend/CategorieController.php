<?php

namespace App\Http\Controllers\Frontend;

use App\Favourite;
use App\Http\Controllers\FrontendController;
use App\Models\Area;
use App\Models\Category;
use App\Models\CategoryShop;
use App\Models\CategoryProduct;
use App\Models\Location;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CategorieController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Frontend';
    }

    public function index($slug)
    {
        $this->data['cate']      = Category::where('slug', '=', $slug)->where('status', '!=', 10)->first();
        $this->data['namepage']  = $this->data['cate']->name;
        $this->data['user']      = auth()->user();

      //  dd($page);
        return view('frontend.category', $this->data);
    }
    public function favourites(){
        $fav = Favourite::where('user_id', '=', Auth::user()->id)->pluck('product_id');
        $this->data['cate']      = Product::whereIn('id', $fav)->get();
        $this->data['namepage']  = "Favoris";
        $this->data['user']      = auth()->user();

        return view('frontend.favourites', $this->data);
    }

}
