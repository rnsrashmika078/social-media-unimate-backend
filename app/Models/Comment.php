<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    protected $fillable = [
        'content',
    ];

    public function comments(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    // public function user(): HasOne
    // {
    //     return $this->hasOne(User::class);
    // }
}
