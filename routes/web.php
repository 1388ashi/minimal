<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


    Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::get('test', function () {
        $categoryIds = [1,2,3];
        $specificationIds = DB::table('category_specification')
            ->whereIn('category_id', $categoryIds)
            ->distinct()
            ->pluck('specification_id')
            ->toArray();
        $specifications = \Modules\Specification\Models\Specification::query()->whereIn('id', $specificationIds)->get();
        dd($specifications);
    });
