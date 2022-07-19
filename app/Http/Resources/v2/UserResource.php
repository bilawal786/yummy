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
            'id' => $this->id,
            'name' => $this->first_name. ' '. $this->last_name ??"",
            'phone' => $this->phone??"",
            'address' => $this->address??"",
            'email' => $this->email??"",
            'password' => $this->password??"",
            'refferal' => $this->refferal ?? "",
            'roles' => $this->roles ??"",
        ];
    }
}
