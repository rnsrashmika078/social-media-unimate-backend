<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/get/messages', [MessageController::class, 'show']);
// Route::post('/show/messages', [MessageController::class, 'store']);


Route::prefix('v1')->group(function () {
    Route::apiResource('friends', FriendController::class);
    Route::apiResource('posts', PostController::class);
    Route::post('posts/{post_id}/like/{friend_id}', [PostController::class, 'toggleLike']);
});
