<?php

use Illuminate\Support\Facades\Route;
use Modules\JobOffer\Http\Controllers\JobOfferController;
use Modules\JobOffer\Http\Controllers\ResumesController;

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
    Route::resource('job-offers',JobOfferController::class);
    Route::resource('resumes',ResumesController::class);
});
