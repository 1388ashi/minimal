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
use Modules\Product\Models\Suggest;
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
        $posts = Post::select('id','title','writer','summary','created_at')->where('status',1)->latest('id')->get();
        $brands = Brand::select('id','status')->where('status',1)->latest('id')->get();
        // $categories = Category::select('id','title')->with('products.suggest')->get();
        // foreach ($categories as $category) {
        //     if ($category->product->suggest->isEmpty()) {
        //         $suggestedProducts = Product::where('category_id', $category->id)->take(8)->get();
        //     }else{
        //         Product::whereHas('recommendations', function ($query) use ($category) {
        //             $query->where('category_id', $category->id);
        //         })->take(5)->get();
        //         $suggestedProducts = Suggest::
        //         select('id','product_id')
        //         ->with('product:id,title,price,discount')
        //         ->whereHas('product.categories', function ($query) use ($category) {
        //             $query->where('id', $category->id);
        //         })->get();
        //     }
        // }

        // $lastProducts = Product::query()
        // ->select('id', 'title', 'discount', 'discount_type', 'price')
        // ->latest('id')
        // ->take(10)
        // ->get();

        // $lastProducts->map(function ($product) {
        //     return $product->setAttribute('price_with_discount', $product->totalPriceWithDiscount());
        // });
        // $mostDiscountProducts = Product::getTopDiscountedProducts();

        // $mostViewedProducts  = Product::orderByViews()->take(10)->get();

        // $bestSellingProducts = DB::table('order_items')
        //     ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
        //     ->groupBy('product_id')
        //     ->orderByDesc('total_quantity')
        //     ->limit(10)
        //     ->get();
        // $productIds = $bestSellingProducts->pluck('product_id');

        // $productsMostSales = DB::table('products')
        //     ->whereIn('id', $productIds)
        //     ->get();

        return response()->success('',compact('sliders','countCategories','customerReview','brands','posts','products'));
    }
}
