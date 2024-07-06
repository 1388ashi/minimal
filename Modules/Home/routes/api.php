<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\HomeController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::name('api')->group(function() {
        Route::get('/home', [HomeController::class,'home']);
        Route::get('/header', [HomeController::class,'header']);
});
