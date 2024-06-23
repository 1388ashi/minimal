<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomerReview\Http\Controllers\CustomerReviewController;

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
    Route::resource('customer-reviews',CustomerReviewController::class);
    Route::delete('customer-reviews/deleteVideo/{product}', [CustomerReviewController::class, 'destroyVideo'])->name('customer-reviews.video.destroy');
});
