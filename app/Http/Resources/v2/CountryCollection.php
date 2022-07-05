<?php

namespace App\Http\Resources\v2;

use Illuminate\Http\Resources\Json\JsonResource;


class CountryCollection extends JsonResource
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
            'id' => $this->id ?? "",
            'name' => $this->name ?? "",
            'slug'   => $this->slug ?? "",
        ];
    }
}
