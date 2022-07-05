<?php

namespace App\Http\Resources\v2;

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
        return [
            "id"          => $this->id ?? "",
            "title"       => $this->title?? "",
            "slug"        => $this->slug ?? "",
            "description" => strip_tags($this->description) ??"",
            "image"       => $this->getFirstMediaUrl('categories')?? "http://lorempixel.com/640/480/city"
        ];
    }
}
