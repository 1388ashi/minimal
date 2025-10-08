<?php

use Illuminate\Support\Facades\Route;
use Modules\Brand\Http\Controllers\Front\BrandController;

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
    Route::get('/brands', [BrandController::class,'index']);
    Route::get('/brands/{slug}', [BrandController::class,'show']);
});
