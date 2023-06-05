<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'id'=> $this->id,
            'name'=> $this->name,
            'logo'=> $this->logo,
            'phones'=> $this->phones,
            'details'=> $this->details,
            'category'=> @$this->category->name,
            'sub_category'=> @$this->subcategory->name,
            'rate'=> 4,
            'following'=> 200,
            'followers'=> 300,
            'reviews'=> 50,
            'images'=> $this->images,
            'provider'=> User::select('id','name','phone_code','phone')->where('id',$this->user_id)->first(),
        ];
    }
}
