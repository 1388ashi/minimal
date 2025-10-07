<?php

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\AboutController;

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
    Route::post('about-us', [AboutController::class, 'store'])
        ->name('about-us.store');
    Route::get('about-us', [AboutController::class, 'edit'])
        ->name('about-us.edit');
    Route::patch('about-us', [AboutController::class, 'update'])
        ->name('about-us.update');
    Route::delete('about-us', action: [AboutController::class, 'destroy'])
        ->name('about-us.destroy');
    Route::delete('/about-us/{aboutUs}/file', [AboutController::class, 'deleteFile'])
        ->name('about-us.deleteFile');


});