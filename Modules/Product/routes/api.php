<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use Modules\Product\Http\Controllers\Api\ProductController;
=======
use Modules\Product\Http\Controllers\api\ProductController;
>>>>>>> 837b696255395ce4abd883ef20025a5d34ae3b4a

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
<<<<<<< HEAD
    route::resource('products',ProductController::class);
=======
    Route::resource('products',ProductController::class);
    
>>>>>>> 837b696255395ce4abd883ef20025a5d34ae3b4a
});
