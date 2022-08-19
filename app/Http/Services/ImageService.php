<?php

namespace App\Http\Services;

use App\Models\CoreImage;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    public function store($parentId, $imgType, $newFileName, $file){
        $image = new CoreImage();
        $image->img_parent_id = $parentId;
        $image->img_type = $imgType;
        $image->img_path = $newFileName;
        $image->img_width = getImgWidth($file);
        $image->img_height = getImgHeight($file);
        $image->added_user_id = Auth::id();
        $image->save();
    }

    public function update($image, $parentId, $imgType, $newFileName, $file){
        $image->img_parent_id = $parentId;
        $image->img_type = $imgType;
        $image->img_path = $newFileName;
        $image->img_width = getImgWidth($file);
        $image->img_height = getImgHeight($file);
        $image->added_user_id = Auth::id();
        $image->update();
    }

    public function getOldImage($imgParentId, $imgType){
        $oldImage = CoreImage::where('img_parent_id',$imgParentId)->where('img_type', $imgType)->first();
        return $oldImage;
    }
}
