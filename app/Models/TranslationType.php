<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationType extends Model
{
    use HasFactory;

    protected $casts = ['name'=>'json'];
}
