<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopProduct;
use App\Models\Order;
use App\Models\OrderLineItem;
use Carbon\Carbon;
class CronController extends Controller
{
    public function product_update()
    {
      $mytime = Carbon::now();
      $heure = $mytime->format('H:i:s');
      $products = ShopProduct::where('hdispob', '<=', $heure)->get();
      foreach($products as $row){
        $product = ShopProduct::find($row['id']);
        $product->quantity = 0;
        $product->save();
      }
      return $products;
    }
    public function order_update()
    {
      $mytime = Carbon::now();
      $heure = $mytime->format('H:i:s');
      $orders_line = OrderLineItem::with('shop_product')->with('order')->get();

      foreach($orders_line as $row){
        foreach($row->shop_product as $dispo){

          if($row->order->status == '17'){
            if($dispo >= $heure){
              $orderl = OrderLineItem::find($row['id']);
              $orderl->order()->update(['status' => '10']);
            }
          }
        }
      }
    }
    public function order_status(){
        $orders = Order::where('status', 17)->get();
        foreach ($orders as $order){
            $time = $order->created_at->diffInHours(Carbon::now(), false);
            if ($time>2){
                $order->status = 20;
                $order->update();
            }
        }
    }
}
