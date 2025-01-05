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

            $categories = Category::select('categories.id')  
            ->join('brand_category', 'categories.id', '=', 'brand_category.category_id')  
            ->get();  
        
        return response()->success('',compact('brands','categories'));
    }
    public function show(Brand $brand): mixed  
    {  
        $moreBrands = Brand::all();  
        $products = Product::where('brand_id', $brand->id)->take(4)->get();  
    
        if ($products->isEmpty()) {  
            $products = Product::latest('id')->take(5)->get();  
        }  
        
        $categoryIds = $brand->categories()->pluck('id'); 
        $categories = Category::whereIn('id', $categoryIds)->get();  
    
        if ($categories->isEmpty()) {  
            $categories = Category::whereNull('parent_id')->take(4)->get();  
        }  

        return response()->success('', 
        compact('brand','products', 'moreBrands','categories'));  
    }  
}