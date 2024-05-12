<?php

namespace App\Models;

use App\Http\Services\IssueService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'added_user_id', 'id');
    }

    public function image(){
        return $this->hasOne(CoreImage::class,'img_parent_id', 'id')->where('img_type', 'project_logo');
    }

    public function issues(){
        return $this->hasMany(issue::class, "project_id","id");
    }

}
