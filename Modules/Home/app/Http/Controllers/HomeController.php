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

        $countCategories = Category::whereNull('parent_id')->select('id','title')->where('status',1)->withCount('products')->get();
        $customerReview = CustomerReview::select('id','name','city','description')->latest('id')->get();
        $posts = Post::select('id','title','writer','summary','created_at')->where('status',1)->latest('id')->take(4)->get();
        $brands = Brand::select('id','status')->where('status',1)->latest('id')->get();

        $categories = Category::query()
        ->with(['parent:id,title','children:id,title,parent_id','recursiveChildren:id,title,parent_id','products'])
        ->whereHas('products')
        ->take(8)
        ->get();
        $workSamples = WorkSample::select('id','title')->take(5)->latest('id')->get();
        $lastProducts = Product::query()
            ->WhereHas('suggestion', function($query) {
                return $query->with('suggestion');
            })
            ->latest('id')
            ->take(8)
            ->get();
        $lastProducts->map(function ($lastProducts) {
            return $lastProducts->setAttribute('final_price', $lastProducts->totalPriceWithDiscount());
        });

        return response()->success('',compact('categories', 'sliders','countCategories','customerReview','brands','posts','products','lastProducts','workSamples'));
    }
}
