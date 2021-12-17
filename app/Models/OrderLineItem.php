<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderLineItem extends Model
{
    protected $table    = 'order_line_items';
    protected $fillable = ['shop_id', 'order_id', 'product_id', 'quantity', 'unit_price', 'discounted_price', 'item_total', 'shop_product_variation_id', 'options', 'options_total'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shop_product()
    {
        $mytime = Carbon::now();
        $heure = $mytime->format('H:i:s');

        return $this->HasMany(ShopProduct::class, 'product_id', 'product_id')->where('shop_products.hdispob', '<=', $heure);
    }

    public function variation()
    {
        return $this->belongsTo(ShopProductVariation::class, 'shop_product_variation_id');
    }
}
