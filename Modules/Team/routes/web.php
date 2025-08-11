<?php

use Illuminate\Support\Facades\Route;
use Modules\Team\Http\Controllers\TeamController;
use Modules\Team\Models\Team;

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
    Route::resource('teams',TeamController::class);
    Route::put('/teams/sort',function () {
        dd(request('teams'));
        Team::setNewOrder(request('teams'));

        return redirect()->back()
        ->with('success', 'ایتم ها با موفقیت مرتب شد.');
    })->name('teams.sort');
});
