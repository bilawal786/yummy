<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Models\Area;
use App\Models\Category;
use App\Models\CategoryShop;
use App\Models\CategoryProduct;
use App\Models\Location;
use App\Models\Shop;
use App\Models\ShopProduct;
use Carbon\Carbon;


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

}
