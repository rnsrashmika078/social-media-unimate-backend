<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Event\Code\TestCollectionIterator;

Route::get('/home', function () {
    return view('home');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/test', [TestController::class,  'index'],);

Route::get("/", [MessageController::class, 'show']);
Route::post("/create", [MessageController::class, 'store']);
