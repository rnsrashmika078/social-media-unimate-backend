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


    public function likedPostsUser()
    {
        return $this->belongsToMany(User::class, 'post_likes');
    }
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_likes');
    }
}
