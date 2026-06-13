<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content',
        'attachment',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedPosts()
    {
        return $this->belongsToMany(User::class, 'post_likes');
    }
    public function commentPosts()
    {
        return $this->belongsToMany(Post::class, 'post_comments');
    }
}
