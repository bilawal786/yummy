<?php

namespace App\Http\Resources\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'name' => $this->first_name. ' '. $this->last_name ??"",
            'username' => $this->username??"",
            'email' => $this->email??"",
            'roles' => $this->getrole->id ??"",
            'phone' => $this->phone??"",
            'address' => $this->address??"",
            'timezone' => $this->timezone??"",
            'balance_id' => $this->balance_id ?? "",
            'refferal' => $this->refferal ?? "",
            'img' =>  $this->images ?? "",


        ];
    }
}
