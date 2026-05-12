<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Friend extends Model
{
    use HasApiTokens;
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
