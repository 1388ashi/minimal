<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Schema\Blueprint;
use Modules\Brand\Models\Brand;
use Modules\Product\Models\Category;



    Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::get('test', function () {
        Schema::create('brand_category', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
            // $categoryIds = [1,2,3];
        // $specificationIds = DB::table('category_specification')
        //     ->whereIn('category_id', $categoryIds)
        //     ->distinct()
        //     ->pluck('specification_id')
        //     ->toArray();
        // $specifications = \Modules\Specification\Models\Specification::query()->whereIn('id', $specificationIds)->get();
        // dd($specifications);
    });
