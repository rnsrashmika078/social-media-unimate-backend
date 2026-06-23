<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/me', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    Route::post('/reset_password', [AuthController::class, 'resetPassword']);
});

Route::prefix('v1/user')->group(function () {
    Route::post('/get-user-profile/{id}', [AuthController::class, 'getUserProfile']);
});


Route::prefix('v1/post')->group(function () {
    Route::post('/add', [PostController::class, 'addPost']);
    Route::get('/{id}', action: [PostController::class, 'getPostsByMe']);
    Route::get('/', action: [PostController::class, 'getPosts']);
    Route::delete('/{id}', action: [PostController::class, 'deletePost']);
    Route::put('/{id}', action: [PostController::class, 'updatePost']);
    Route::post('/like/{post_id}/{user_id}', [PostController::class, 'likePost']);
    Route::get('/like/{post_id}', [PostController::class, 'getLikeByPostId']);
    Route::post('/comment/{post_id}/{user_id}', [PostController::class, 'commentPost']);
    Route::get('/comment/{post_id}', [PostController::class, 'getCommentByPostId']);
})->middleware('auth:sanctum');
