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
       $brands = Brand::select('id','title','slug','status','description','category_id')->get();
       $categories = Category::whereIn('id', Brand::pluck('category_id'))->get();
        
        return response()->success('',compact('brands','categories'));
    }
    public function show($slug): mixed  
    {  
        dd(Brand::where('slug',$slug)->first());
        $brand = Brand::where('slug',$slug)->firstOrFail();
        $moreBrands = Brand::where('id', '!=', $brand->id)->get();  
        $products = Product::where('brand_id',$brand->id)->with('categories:id,title')->take(4)->get();
        if (!$products) {
            $products = Product::latest('id')->take(5)->get();
        }  
        $categories = Category::whereNull('parent_id')->take(4)->get();  

        return response()->success('', 
        compact('brand','products', 'moreBrands','categories'));  
    }  
}