<?php

namespace App\Http\Resources\v2;

use App\Favourite;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "product_id" => $this->product->id,
            "product_image" => $this->product->images,
            "shop_id" => $this->shop_id ,
            "shop_name" => $this->shop->name?? "" ,
            "address" => $this->shop->address ,
            "product_name" => $this->product->name ?? "" ,
            "price" => $this->product->unit_price ?? 0 ,
            "discount_price" => $this->discount_price ?? 0 ,
            "start_time" => \Carbon\Carbon::createFromFormat('H:i:s',$this->hdispoa)->format('H:i') ?? "" ,
            "end_time" =>\Carbon\Carbon::createFromFormat('H:i:s',$this->hdispob)->format('H:i')  ?? "" ,
            "likes" =>  \App\Favourite::where('product_creator', $this->shop->user->id)->get()->unique('user_id')->count() ?? 0,
            "quantity" => $this->quantity ?? 0 ,
            "country" => $this->shop->user->country->name ?? 0 ,
            "shopImage" => $this->shop->images ?? "" ,
            "shopLogo" => $this->shop->logo ?? "" ,
            "product_description" => $this->product->description ?? "" ,
            "shop_description" => $this->shop->description ?? "" ,
            "is_like" => true ,
        ];
    }
}
