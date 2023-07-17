<?php

namespace App\Services\Api;

use App\Http\Resources\TranslationResource;
use App\Models\City;
use App\Models\Slider;
use App\Models\TranslationLanguage;
use App\Models\TranslationType;

class GeneralService
{
    public function cities(){
        $cities = City::select("id","name_".accept_language()." as name")->get();
        return helperJson($cities, '');
    }

    public function translations(){
        $translations = TranslationType::all();
        return helperJson(TranslationResource::collection($translations), '');
    }

    public function translation_languages(){
        $translation_languages = TranslationLanguage::all();
        return helperJson(TranslationResource::collection($translation_languages), '');
    }

    public function sliders(){
        $sliders = Slider::all();
        return helperJson($sliders, '');
    }
}
