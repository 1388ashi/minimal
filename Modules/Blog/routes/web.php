<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\ArticleController;
use Modules\Blog\Http\Controllers\CategoryController;
use Modules\Blog\Http\Controllers\NewsController;
use Modules\Blog\Http\Controllers\PostController;

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

    Route::resource('blog-categories',CategoryController::class);
    
    Route::patch('articles/update-product-categories/{id}', [ArticleController::class, 'updateProductCategories'])
        ->name('articles.update-product-categories');

    Route::resource('news',NewsController::class);
    Route::resource('articles',ArticleController::class);
});