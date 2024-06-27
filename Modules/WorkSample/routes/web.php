<?php

use Illuminate\Support\Facades\Route;
use Modules\WorkSample\Http\Controllers\WorkSampleController;

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
    Route::resource('work-samples',WorkSampleController::class);
    Route::delete('work-samples/deleteGalleries/{id}', [WorkSampleController::class, 'destroyGalleries'])->name('work-samples.galleries.destroy');
});
