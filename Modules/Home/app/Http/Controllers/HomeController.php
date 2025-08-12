<?php

namespace Modules\Home\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Blog\Models\BlogCategory;
use Modules\Blog\Models\Post;
use Modules\Brand\Models\Brand;
use Modules\CustomerReview\Models\CustomerReview;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;
use Modules\Slider\Models\Slider;
use Modules\WorkSample\Models\WorkSample;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(Request $request): JsonResponse
    {
        $sliders = Slider::query()->where('status',1)->select('id','title','link','status')->latest('id')->take(4)->get();

        $products = Product::query()
        ->select('id','title','price','discount')
        ->when($request->has('title'), function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        })
        ->where('status',1)
        ->latest('id')
        ->paginate();
        $products->map(function ($products) {
            return $products->setAttribute('final_price', $products->totalPriceWithDiscount());
        });
        $countCategories = Category::whereNull('parent_id')->select('id','title')->where('status',1)->withCount('products')->get();
        $customerReview = CustomerReview::select('id','name','city','description')->latest('id')->get();
        $posts = Post::select('id','title','writer','summary','created_at')->where('status',1)->latest('id')->take(4)->get();
        $brands = Brand::select('id','status','order')->where('status',1)->orderBy('order', 'asc')->get();

        $categories = Category::query()
        ->with(['parent:id,title', 'children:id,title,parent_id', 'recursiveChildren:id,title,parent_id', 'products'])
        ->whereHas('products')
        ->take(8)
        ->get();  
        $workSamples = WorkSample::select('id','title')->take(5)->latest('id')->get();
        $lastProducts = Product::query()
            ->WhereHas('suggestion', function($query) {
                return $query->with('suggestion');
            })
            ->latest('id')
            ->where('status',1)
            ->take(8)
            ->get();
        $lastProducts->map(function ($lastProducts) {
            return $lastProducts->setAttribute('final_price', $lastProducts->totalPriceWithDiscount());
        });

        return response()->success('',compact('categories', 'sliders','countCategories','customerReview','brands','posts','products','lastProducts','workSamples'));
    }
    public function header(): JsonResponse
    {
        $productCategories = Category::select('id','title','parent_id')
        ->where('status',1)
        ->whereNull('parent_id')
        ->with(['children:id,title,parent_id'])
        ->get();

        $postCategories = BlogCategory::select('id','title')
        ->where('status',1)
        ->get();

        return response()->success('',compact('productCategories', 'postCategories'));
    }
    public function menus(){
        $brands = Brand::select('id', 'title', 'status', 'description')->orderBy('order', 'asc')->get();
        foreach ($brands as $brand) {
            $brand['link']  = 'https://minimalzee.ir/brands/' . $brand->id; 
        }
        $productCategories = Category::select('id','title','parent_id')
            ->where('status',1)
            ->whereNull('parent_id')
            ->with(['children:id,title,parent_id'])
            ->get();
        foreach ($productCategories as $item) {
            $item['link']  = 'https://minimalzee.ir/products?category_id=' . $item->id; 
        }
        
        $menus = [
        [
            'link' => 'https://minimalzee.ir/',
            'title' => 'مینیمال زی'
        ],
        [
            'link' => 'https://minimalzee.ir/brands/',
                'title' => 'برند ها',
                'children' => $brands 
            ],
            [
                'link' => 'https://minimalzee.ir/categories/',
                'title' => 'محصولات',
                'children' => $productCategories 
            ],
            [
                'link' => 'https://minimalzee.ir/weblog/',
                'title' => 'بلاگ'
            ],
            [
                'link' => 'https://minimalzee.ir/about-us/',
                'title' => 'درباره ما'
            ],
        ];

        return response()->success('',compact('menus'));
    }
}
