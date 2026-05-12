<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
     protected $fillable = [
        'firstName',
        'lastName',
        'address',
        'email',
        'username',
        'dp',
        'title',

    ];
    public function posts()
    {
        return $this->hasMany(Post::class, 'friend_id');
    }
    public function post_likes()
    {
        return $this->belongsToMany(Post::class, 'post_likes');
    }
}
