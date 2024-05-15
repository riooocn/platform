<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get("/",[\App\Http\Controllers\HomeController::class, 'home']);

Route::view('/template','template');

Route::controller(\App\Http\Controllers\UserController::class)->group(function(){
    Route::get('/login','login')->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);
    Route::post('/login','dologin')->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);
    Route::post('/logout','doLogout')->middleware([\App\Http\Middleware\OnlyMemberMiddleware::class]);
});