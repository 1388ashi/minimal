<?php

namespace Modules\Brand\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Brand\Models\Brand;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;

class BrandController extends Controller 
{
    public function index()
    {
        $brands = Brand::select('brands.id', 'brands.title', 'brands.status', 'brands.description')  
            ->with('categories:id,title')->get();  

        $categoryIds = $brands->pluck('categories.*.id')->flatten()->unique();
        $categories = Category::whereIn('id', $categoryIds)->get();
        
        return response()->success('',compact('brands','categories'));
    }
    public function show(Brand $brand): mixed  
    {  
        // دریافت تمامی برندها  
        $moreBrands = Brand::all();  
        
        // دریافت ۴ محصول مربوط به برند انتخاب شده  
        $products = Product::where('brand_id', $brand->id)->take(4)->get();  
        
        // اگر محصولات خالی بودند، ۵ محصول اخیر را دریافت کن  
        if ($products->isEmpty()) {  
            $products = Product::latest('id')->take(5)->get();  
        }  
        
        // دریافت ID های دسته‌بندی‌های مربوط به برند  
        $categoryIds = $brand->categories()->pluck('categories.id'); // مشخص کردن جدول به منظور جلوگیری از ابهام  
        
        // دریافت دسته‌بندی‌ها بر اساس ID  
        $categories = Category::whereIn('id', $categoryIds)->get();  
    
        // بازگشت پاسخ  
        return response()->success('', compact('brand', 'products', 'moreBrands', 'categories'));  
    }
}