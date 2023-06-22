<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\CategoryResource;
use App\Models\Rate;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProvidersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'watts'=> $this->phone_code.$this->phone,
            'email'=>$this->email,
            'image'=>$this->image,
            'address'=>$this->address,
            'provider_type'=>$this->provider_type,
            'about_me'=>$this->about_me,
            'experience'=>$this->experience,
            'previous_experience'=>$this->previous_experience,
            'city'=> @$this->city->{"name_".accept_language()},
        ];
    }
}
