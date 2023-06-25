<?php

namespace App\Http\Resources;

use App\Models\Cities;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
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
            'user'=> [
                'id'=>$this->id,
                'name'=>$this->name,
                'phone'=>$this->phone,
                'email'=>$this->email,
                'status'=>$this->status,
                'user_type'=>$this->role_id,
                'watts'=> $this->phone_code.$this->phone,
                'image'=>$this->image,
                'address'=>$this->address,
                'provider_type'=>$this->provider_type,
                'translation_type_id'=>$this->translation_type_id,
                'about_me'=>$this->about_me,
                'experience'=>$this->experience,
                'previous_experience'=>$this->previous_experience,
                'certificate_image'=>$this->certificate_image,
                'location_image'=>$this->location_image,
                'commercial_register_image'=>$this->commercial_register_image,
                'city'=> @$this->city->{"name_".accept_language()},
            ],
            'access_token'=>'Bearer '.$this->token??'',
            'token_type'=>'bearer'
        ];
    }
}
