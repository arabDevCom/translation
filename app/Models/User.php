<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $fillable=[
        'name',
        'email',
        'phone',
        'address',
        'role_id',
        'password',
        'status',
        'image',
        'experience',
        'about_me',
        'previous_experience',
        'city_id',
        'translation_type_id',
        'provider_type',
        'certificate_image',
        'location_image',
        'commercial_register_image',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];




    ##  Mutators and Accessors
    public function getImageAttribute()
    {
        return isset($this->attributes['image']) ? get_file($this->attributes['image']) : "";
    }

    public function categories(){
        return $this->hasMany(Category::class,'user_id');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }//end getJWTIdentifier

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }//end of getJWTCustomClaims



}
