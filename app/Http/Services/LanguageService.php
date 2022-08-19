<?php

namespace App\Http\Services;

use App\Models\CoreImage;
use App\Models\Language;
use App\Models\LanguageString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Stichoza\GoogleTranslate\GoogleTranslate;

class LanguageService
{
    protected $languageStringService, $imageService;

    public function __construct(LangaugeStringService $languageStringService, ImageService $imageService)
    {
        $this->languageStringService = $languageStringService;
        $this->imageService = $imageService;
    }

    public function getLanguages($perPage){
        $languages = Language::with(['image'])->latest("id")->paginate($perPage);
        return $languages;
    }

    public function store($request){
        // get all english lang strings
        $languageStrings = $this->languageStringService->getLanguageStrings(2);

        DB::beginTransaction();
        try {
            // create new language
            $language = new Language();
            $language->name = $request->name;
            $language->symbol = $request->symbol;
            $language->status = $request->status;
            $language->added_user_id = Auth::id();
            $language->save();

            $file = $request->file('coverImg');
            // save file in local
            $img = Image::make($file);
            $newFileName = uniqid()."_lang.".$file->getClientOriginalExtension();
            $img->save(public_path()."/storage/img/language/".$newFileName,50);
//            $file->storeAs("public/img/language/",$newFileName);

            // save file in db
           $this->imageService->store($language->id,'lang_flag', $newFileName, $file);

            // save language strings
            foreach($languageStrings as $engLangString){
                $languageString = new LanguageString();
                $languageString->key = $engLangString->key;
                $languageString->value = GoogleTranslate::trans($engLangString->value, $language->symbol, null);
                $languageString->language_id = $language->id;
                $languageString->added_user_id = Auth::id();
                $languageString->save();
            }

            // generate lang json file
            generateLangJson($language->id, $language->symbol);

            DB::commit();
        }catch (\Throwable $e){
            Storage::delete('public/img/language/'.$newFileName);
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function update($language, $request){

        // get all english lang strings
        $languageStrings = $this->languageStringService->getLanguageStrings(2);

        DB::beginTransaction();
        try {
            // update language
            $language->name = $request->name;
            $language->symbol = $request->symbol;
            $language->status = $request->status;
            $language->added_user_id = Auth::id();
            $language->update();

            if (!empty($request->coverImg)){
                // del old image
                $imgPath = '/public/img/language/';
                $oldImage = CoreImage::where('img_parent_id',$language->id)->first();
                Storage::delete($imgPath.$oldImage->img_path);

                $file = $request->file('coverImg');

                // save file in local
                $img = Image::make($file);
                $newFileName = uniqid()."_lang.".$file->getClientOriginalExtension();
                $img->save(public_path()."/storage/img/language/".$newFileName,50);

                // save file in db
                $this->imageService->store($language->id,'lang_flag', $newFileName, $file);

            }



            // save language strings
            foreach($languageStrings as $engLangString){
                $languageString = new LanguageString();
                $languageString->key = $engLangString->key;
                $languageString->value = GoogleTranslate::trans($engLangString->value, $language->symbol, null);
                $languageString->language_id = $language->id;
                $languageString->added_user_id = Auth::id();
                $languageString->save();
            }

            // generate lang json file
            generateLangJson($language->id, $language->symbol);

            DB::commit();
        }catch (\Throwable $e){
            Storage::delete('public/img/language/'.$newFileName);
            DB::rollBack();
            return $e->getMessage();
        }
    }

}
