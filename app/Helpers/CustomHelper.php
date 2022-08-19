<?php

use App\Models\CoreImage;
use App\Models\LanguageString;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

if (!function_exists('Test')){
    function Test(){
        $greeting = "min ga lar par";
        return $greeting;
    }
}

if ( !function_exists('renderView')){
    function renderView($componentPath, $dataForView = null){
        if(empty($dataForView)){
            return Inertia::render($componentPath);
        } else {
            return Inertia::render($componentPath,$dataForView);
        }
    }
}

if ( !function_exists('saveFileLocal')){
    function saveFileLocal($request, $fileVar, $fileName){
        $file = $request->file('coverImg');
        $images = getimagesize($request->coverImg);
        $newFileName = uniqid()."_lang.".$file->getClientOriginalExtension();
        $file->storeAs("public/img/language/",$newFileName);
    }
}

if ( !function_exists('generateLangJson')){
    function generateLangJson($languageId, $languageSymbol){
        $langStrings = [];
        $lang_str = LanguageString::select('key', 'value')->where('language_id',$languageId)->get();

        foreach ($lang_str as $str){
            $langStrings[$str['key']] = $str['value'];
        }
        $value = json_encode($langStrings,JSON_UNESCAPED_UNICODE);

        $file = lang_path($languageSymbol.'.json');
        file_put_contents($file,$value);
    }
}

if ( !function_exists('getImgWidth')){
    function getImgWidth($file){
        $img = Image::make($file);
        $imgWidth = $img->width();
        return $imgWidth;
    }
}

if ( !function_exists('getImgHeight')){
    function getImgHeight($file){
        $img = Image::make($file);
        $imgHeight = $img->height();
        return $imgHeight;
    }
}

if ( !function_exists('saveImgInLocal')){
    function saveImgInLocal($file, $folderName){
        $img = Image::make($file);
        $newFileName = uniqid()."_".$folderName.".".$file->getClientOriginalExtension();
        $img->save(public_path()."/storage/img/".$folderName."/".$newFileName,50);
        return $newFileName;
    }
}

if ( !function_exists('delOldImage')){
    function delOldImage($imgParentId, $imgPathString, $imgType){
        $imgPath = $imgPathString;
        $oldImage = CoreImage::where('img_parent_id',$imgParentId)->where('img_type', $imgType)->first();
        Storage::delete($imgPath.$oldImage->img_path);
    }
}

