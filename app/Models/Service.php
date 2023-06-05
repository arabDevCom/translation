<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'phones' =>'array',
        'images' =>'array',
    ];

    ##  Mutators and Accessors
    public function getLogoAttribute($value)
    {
//        dd($value);
        return get_file($this->attributes['logo']);
    }

    public function getImagesAttribute($value)
    {
        $images = [];
        foreach(json_decode($value, true) as $image){
            $images[] = get_file($image);
        }
        return $images;
    }

    // category of service
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }//end fun

    // sub category  of service
    public function subcategory()
    {
        return $this->belongsTo(Category::class,'category_id');
    }//end fun

    public function provider()
    {
        return $this->belongsTo(User::class,'user_id');
    }//end fun
}
