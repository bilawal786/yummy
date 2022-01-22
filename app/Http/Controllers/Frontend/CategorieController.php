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
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    public function tradersindex()
    {
        $this->data['traders']      = Shop::where('location_id', Auth::user()->address)->paginate(10);
        $this->data['namepage']  = "Nos commerçants";
        $this->data['user']      = auth()->user();
        return view('frontend.tradersindex', $this->data);
    }
    public function tradersSearch(Request $request){
        $this->data['traders'] = Shop::where('name','LIKE','%'.$request->name.'%')->paginate(10);
        $this->data['namepage']  = "Résultat de la recherche";
        $this->data['user']      = auth()->user();
        return view('frontend.tradersindex', $this->data);
    }
    public function favourites(){
        $fav = Favourite::where('user_id', '=', Auth::user()->id)->get()->unique('product_creator');
        $p_ids = $fav->pluck('product_id');
        $this->data['cate']      = Product::whereIn('id', $p_ids)->get();
        $this->data['namepage']  = "Favoris";
        $this->data['user']      = auth()->user();

        return view('frontend.favourites', $this->data);
    }
    public function favouritremove($id){
        $fav = Favourite::where('user_id', '=', Auth::user()->id)->where('product_id', $id)->first();
        $fav->delete();
        return redirect()->back();
    }
    public function subcategory($id){
        $this->data['namepage']  = "Sous-catégories";
        $this->data['user']      = auth()->user();
        $this->data['subcategory']      = SubCategory::where('category_id', $id)->get();
        return view('frontend.subcategory', $this->data);
    }
    public function subcategoryproducts($id){
        $this->data['cate']      = Product::where('subcategories', $id)->get();
        $this->data['namepage']  = "Produits";
        $this->data['user']      = auth()->user();

        return view('frontend.subcategories', $this->data);
    }

}
