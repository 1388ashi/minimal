<?php

use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\Admin\RoleController;

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

    //auth
    Route::get('/permission', [RoleController::class,'index'])->name('roles');
    Route::get('/permission/create', [RoleController::class,'create'])->name('roles.create');
    Route::post('/permission', [RoleController::class,'store'])->name('roles.store');
    Route::get('/permission/{role}/edit', [RoleController::class,'edit'])->name('roles.edit');
    Route::patch('/permission/{role}', [RoleController::class,'update'])->name('roles.update');
    Route::delete('/permission/delete/{role}', [RoleController::class,'destroy'])->name('roles.destroy');
});
