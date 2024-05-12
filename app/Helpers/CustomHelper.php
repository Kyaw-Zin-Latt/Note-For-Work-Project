<?php

use App\Models\CoreImage;
use App\Models\Language;
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

if ( !function_exists('changeStatus')){
    function changeStatus($model){
        if ($model->status){
            $model->status = 0;
        } else {
            $model->status = 1;
        }
        $model->update();
        return $model;
    }
}

if ( !function_exists('deeplinkGenerate')){
    function deeplinkGenerate($title, $description, $img){

        // check description length
        if(strlen($description)>6605){
            $description = substr($description, 0, 6605);
        }

        // $title = strtolower($title);
        // $item_name = str_replace(' ', '-', $title);
        // $longUrl= $backend_setting->dyn_link_deep_url.$id;

        $landingPage= "http://localhost:8000";

        //Web API Key From Firebase
        $key = "AIzaSyD8q_shdfMpO3cr1y_WQ_cLm-C5kSnk05M";

        //Firebase Rest API URL
        $url = "https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=" . $key;

        //To link with Android App, so need to provide with android package name
        $androidInfo = array(
            // "androidPackageName" => $backend_setting->dyn_link_package_name,
            // "androidFallbackLink" => $landingPage,
        );

        //For iOS
        $iOSInfo = array(
            // "iosBundleId" => $backend_setting->ios_boundle_id ,
            // "iosAppStoreId" => $backend_setting->ios_appstore_id,
            // "iosFallbackLink" => $landingPage,
        );

        //For meta data when share the URL
        $socialMetaTagInfo = array(
            "socialDescription" => $description,
            "socialImageLink"   => $img,
            "socialTitle"       => $title
        );

        //For only 4 character at url
        $suffix = array(
            "option" => "SHORT"
        );

        $data = array(
            "dynamicLinkInfo" => array(
               "dynamicLinkDomain" => "letsshare.page.link",
            //    "link" => $longUrl,
               "link" => $landingPage,
            //    "androidInfo" => $androidInfo,
            //     "iosInfo" => $iOSInfo,
               "socialMetaTagInfo" => $socialMetaTagInfo
            ),
            "suffix" => $suffix
       );

       $headers = array('Content-Type: application/json');

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data) );

        $data = curl_exec ( $ch );
        curl_close ( $ch );

        if($data != false){
            $short_url = json_decode($data);
            if(isset($short_url->error)){
                $status = [
                    'msg' => $short_url->error->message,
                    'flag' => 'error',
                ];
                return $status;
            } else {
                $status = [
                    'msg' => $short_url->shortLink,
                    'flag' => 'success',
                ];
                return $status;

            }
        }else{
            $status = [
                'msg' => 'Wrong Configuration',
                'flag' => 'error',
            ];
            return $status;

        }
    }
}



