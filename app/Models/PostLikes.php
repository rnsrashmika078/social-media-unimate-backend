<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostLikes extends Model
{
    //
    protected $fillable = [
        'post_id',
        'user_id'
    ];
}
