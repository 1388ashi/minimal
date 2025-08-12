<?php

use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\Api\MenuController as ApiMenuController;

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
        Route::get('/menus', [ApiMenuController::class,'index']);
});
