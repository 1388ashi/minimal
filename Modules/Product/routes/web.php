<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\CategoryController;
use Modules\Product\Http\Controllers\ColorController;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\SuggestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    //products
    Route::resource('categories',CategoryController::class);
    Route::delete('categories/deleteImage/{category}', [CategoryController::class, 'destroyImage'])->name('categories.image.destroy');

    Route::resource('products',ProductController::class);
    Route::post('/get-specifications', [ProductController::class, 'getSpecifications'])->name('get-specifications');
    Route::delete('products/deleteGalleries/{id}', [ProductController::class, 'destroyGalleries'])->name('products.galleries.destroy');
    Route::delete('products/deleteVideo/{product}', [ProductController::class, 'destroyVideo'])->name('products.video.destroy');

    Route::resource('suggestions',SuggestController::class);
    //colors
    Route::resource('colors',ColorController::class);
});
