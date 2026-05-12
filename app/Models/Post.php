<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content',
        'attachment',
        'friend_id'

    ];
    // pivoting table

    public function likes()
    {
        return $this->belongsToMany(Friend::class, 'post_likes');
    }

    public function postedBy()
    {
        return $this->belongsTo(Friend::class, 'friend_id');
    }
}

// mental model

// hasMany -> one user has many post
// belongToMany -> many records has many other records ( post likes has many users)
