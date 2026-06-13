<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1/post')->group(function () {
    Route::post('/', [PostController::class, 'addPost']);
    Route::get('/{id}', action: [PostController::class, 'getPosts']);
    Route::delete('/{id}', action: [PostController::class, 'deletePost']);
    Route::put('/{id}', action: [PostController::class, 'updatePost']);
    Route::post('/like/{post_id}/{user_id}', [PostController::class, 'likePost']);
    Route::post('/comment/{post_id}/{user_id}', [PostController::class, 'commentPost']);
})->middleware('auth:sanctum');

