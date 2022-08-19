<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function image(){
        return $this->hasOne(CoreImage::class,'img_parent_id', 'id')->where('img_type', 'project_logo');
    }
}
