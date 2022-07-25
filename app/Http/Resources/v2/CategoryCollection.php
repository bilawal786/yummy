<?php

namespace App\Http\Resources\v2;

use App\Models\ShopProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          foreach ($this->products->pluck('id') as $product_id){
              $shopProduct = ShopProduct::where(['product_id' => $product_id])->where('quantity', '>', 0)->with('product')->with('shop')->get();
               $qty=0;
              foreach ($shopProduct as $shop){
                  $qty = $shop->quantity;
              }
          }

        return [
            "id"          => $this->id,
            "title"       => $this->name?? "",
            "slug"        => $this->slug ?? "",
            "description" => strip_tags($this->description) ??"",
            "image"       => $this->getFirstMediaUrl('categories')?? "http://lorempixel.com/640/480/city",
            "quantity"    => $qty,
        ];
    }
}
