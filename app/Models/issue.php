<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class issue extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'added_user_id', 'id');
    }

    public function team(){
        return $this->belongsTo(Team::class, "come_from_id",'id');
    }

    public function project(){
        return $this->belongsTo(Project::class, "project_id", 'id');
    }
}
