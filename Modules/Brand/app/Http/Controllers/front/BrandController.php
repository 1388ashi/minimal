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
        $brands = Brand::select('brands.id', 'brands.title', 'brands.status', 'brands.description','brands.slug')  
            ->with('categories:id,title')->orderBy('order', 'asc')->get()->makeHidden(['background']);  

        $categoryIds = $brands->pluck('categories.*.id')->flatten()->unique();
        $categories = Category::whereIn('id', $categoryIds)->get();

        return response()->success('',compact('brands','categories'));
    }
    public function show($slug): mixed  
    {  
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