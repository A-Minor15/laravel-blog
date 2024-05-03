<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function post(){
        return $this->belongsTo(Post::class);
    }

    # 1 to many relationship (Inverse)
    # Use this method to retrieve the owner of the comment
    public function user() {
        return $this->belongsTo(User::class);
    }
}
