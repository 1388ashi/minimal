<?php

use Illuminate\Support\Facades\Route;
use Modules\PurchaseAdvisor\Http\Controllers\PurchaseAdvisorController;

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

    Route::resource('purchase-advisors',PurchaseAdvisorController::class);
});