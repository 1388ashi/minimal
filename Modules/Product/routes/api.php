<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Api\AdvisorController;
use Modules\Product\Http\Controllers\Api\CommentController;

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
    Route::get('/products', [\Modules\Product\Http\Controllers\Api\ProductController::class,'index']);
    Route::get('/products/{id}', [\Modules\Product\Http\Controllers\Api\ProductController::class,'show']);
    
});
