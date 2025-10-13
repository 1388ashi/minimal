<?php

namespace Modules\Brand\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Brand\Models\Brand;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;
use Modules\Slider\Models\BrandSlider;

class BrandController extends Controller 
{
    public function index()
    {
        $brands = Brand::select('id', 'title', 'status', 'slug')
            ->with('categories:id,title')
            ->orderBy('order', 'asc')
            ->get()
            ->makeHidden(['background', 'white_image']);

        $upSliders = BrandSlider::where('status', 1)
            ->where('type', 'up')
            ->select('id', 'title', 'link', 'status', 'type')
            ->latest('id')
            ->take(4)
            ->get();

        $downSliders = BrandSlider::where('status', 1)
            ->where('type', 'down')
            ->select('id', 'title', 'link', 'status', 'type')
            ->latest('id')
            ->take(4)
            ->get();

        $categoryIds = $brands->flatMap(fn($brand) => $brand->categories->pluck('id'))->unique();

        $categories = Category::select('id','title','status','slug')
            ->whereIn('id', $categoryIds)
            ->where('status',1)
            ->get()
            ->makeHidden(['dark_image']);

        $brands->each->makeHidden('categories');

        return response()->success('', compact('brands', 'categories', 'downSliders', 'upSliders'));
    }
    public function show($slug): mixed  
    {  
        $brand = Brand::where('slug', $slug)->firstOrFail()->makeHidden('dark_image');

        $moreBrands = Brand::select('id','title','slug')->where('id', '!=', $brand->id)->take(5)->get();

        $products = Product::select('id','title','slug')
            ->where('brand_id', $brand->id)
            ->take(4)
            ->get()
            ->makeHidden(['galleries','video','total_price_with_discount']);

        if ($products->isEmpty()) {
            $products = Product::select('id','title','slug')
                ->latest('id')
                ->take(5)
                ->get()
                ->makeHidden(['galleries','video','total_price_with_discount']);
        }

        $categories = Category::select('id','title','slug')->whereHas('brands', fn ($q) => $q->where('brands.id', $brand->id))
            ->take(4)
            ->get()
            ->makeHidden('dark_image');
        if ($categories->isEmpty()) {
            $categories = Category::select('id','title','slug')
                ->latest('id')
                ->take(4)
                ->get()
                ->makeHidden('dark_image');
        }
            
        return response()->success('', 
        compact('brand','products', 'moreBrands','categories'));  
    }  
}