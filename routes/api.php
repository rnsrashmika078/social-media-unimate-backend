<?php

use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/get/messages', [MessageController::class, 'show']);
// Route::post('/show/messages', [MessageController::class, 'store']);


Route::prefix('v1')->group(function () {
    Route::apiResource('messages', MessageController::class);
});
