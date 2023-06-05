<?php

namespace App\Services\Api;

use App\Http\Resources\TranslationResource;
use App\Models\City;
use App\Models\TranslationType;

class GeneralService
{
    public function cities(){

        $cities = City::select("id","name_".accept_language()." as name")->get();
//        dd($cities);
        return helperJson($cities, '');
    }

    public function translations(){
        $translations = TranslationType::all();
        return helperJson(TranslationResource::collection($translations), '');
    }
}
