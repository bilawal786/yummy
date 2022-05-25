<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopProduct;
use App\Rank;
use App\User;
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
        $rank = Rank::all();
        return view('admin.salesperson.details', compact('products','id','rank'));
    }
    public function updateRank(Request $request){

        $user = User::where('id','=',$request->user_id)->first();
        $user->rank_id = $request->rank_id;
        $user->update();
        return redirect()->back()->withSuccess('The User Rank Updates Successfully');
    }
}
