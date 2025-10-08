<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\api\PostsController;

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
    Route::get('/posts', [PostsController::class,'index']);
    Route::get('/posts/{slug}', [PostsController::class,'show']);
});
