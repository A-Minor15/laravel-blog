<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    # Use this method to get the owner of the post
    public function user(){
        return $this->belongsTo(User::class);
    }

    # Use this method to retrieve/get the comments of the post
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
