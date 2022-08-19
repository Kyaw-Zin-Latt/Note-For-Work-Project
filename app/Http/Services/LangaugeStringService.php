<?php

namespace App\Http\Services;

use App\Models\LanguageString;

class LangaugeStringService
{

    public function getLanguageStrings($languageId){
        $languageStrings = LanguageString::where("language_id",$languageId)->get();
        return $languageStrings;
    }

    public function store(){

    }
}
