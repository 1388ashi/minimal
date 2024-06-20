<?php

namespace Modules\Home\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Blog\Models\Post;
use Modules\Brand\Models\Brand;
use Modules\CustomerReview\Models\CustomerReview;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;
use Modules\Slider\Models\Slider;

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

        $countCategories = Category::whereNull('parent_id')->select('id','title')->where('status',1)->withCount('products')->get();
        $customerReview = CustomerReview::select('id','name','city','description')->latest('id')->get();
        $posts = Post::select('id','title','writer','summary','created_at')->where('status',1)->latest('id')->take(4)->get();
        $brands = Brand::select('id','status')->where('status',1)->latest('id')->get();

        $categories = Category::query()
            ->WhereHas('products', function($query) {
                return $query->with('products');
            })
            ->take(8)
            ->get();
            $lastProducts = Product::query()
            ->WhereHas('suggestion', function($query) {
                return $query->with('suggestion');
            })
            ->take(8)
            ->latest('id')
            ->get();

        return response()->success('',compact('categories', 'sliders','countCategories','customerReview','brands','posts','products','lastProducts'));
    }
}
