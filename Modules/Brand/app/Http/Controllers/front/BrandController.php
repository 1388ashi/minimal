<?php

namespace Modules\Brand\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Brand\Models\Brand;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;

class BrandController extends Controller 
{
    public function index()
    {
        $brands = Brand::select('id','title','status','description')->get();
        
        return response()->success('',compact('brands'));
    }
    public function show(Brand $brand): mixed  
    {  
        $moreBrands = Brand::where('id', '!=', $brand->id)->get();  
        $products = Product::where('brand_id',operator: $brand->id)->take(4)->get();
        if (!$products) {
            $products = Product::latest('id')->take(5)->get();
        }  
        $categories = Category::whereNull('parent_id')->take(4)->get();  

        return response()->success('', 
        compact('brand','products', 'moreBrands','categories'));  
    }  
}