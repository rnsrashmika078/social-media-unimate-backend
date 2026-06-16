<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content',
        'attachment',
        'user_id',
        // 'likes_count',
        // 'comments_count'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'post_likes');
    }
    public function comments()
    {
        return $this->hasMany(PostComments::class);
    }
}
