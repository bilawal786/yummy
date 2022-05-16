<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesPersonController extends Controller
{
    public function salesPersonVendors(){
        $shops = Shop::where('salesperson', Auth::user()->id)->get();
        return view('admin.salesperson.vendors', compact('shops'));
    }
    public function details($id){
        $products = ShopProduct::where('salesperson', $id)->get();
        return view('admin.salesperson.details', compact('products'));
    }
}
