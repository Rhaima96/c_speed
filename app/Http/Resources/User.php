<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'role'=>$this->role,
            'offre'=>$this->offre,
            'adress'=>$this->adress,
            'phone'=>$this->phone,
            'expiration'=>$this->expiration,
            'c_id'=>$this->c_id
        ];
    }
}
