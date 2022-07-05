<?php

namespace App\Http\Resources\v2;

use Illuminate\Http\Resources\Json\JsonResource;


class SettingCollection extends JsonResource
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
            "link"          => $this->link ?? "",
            "images"       => $this->images?? "",
        ];
    }
}
