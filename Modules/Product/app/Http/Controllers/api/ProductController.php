<?php

namespace Modules\Product\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Comment\Models\Comment;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categories = Category::select('id','title','parent_id')->whereNull('parent_id')->with(['children:id,title,parent_id','recursiveChildren:id,title,parent_id','products:id,title,price,discount,created_at'])->get();

        $searchProducts = Product::query()
        ->when($request->has('title'), function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        })
        ->when($request->has('min_price') && $request->has('max_price'), function ($query) use ($request) {
            $query->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
        })
        ->where('status',1)
        ->latest('id')
        ->paginate(20);
        
        $lastProducts = Product::query()
        ->select('id', 'title', 'price','discount','slug','created_at')
        ->where('status',1)
        ->latest('id')
        ->paginate(20);

        $lastProducts->map(function ($product) {
            return $product->setAttribute('price_with_discount', $product->totalPriceWithDiscount());
        });

        $mostViewedProducts  = Product::orderByViews()->paginate(20);
        $topPriceProducts = Product::getTopPriceProducts();
        $topCheapProducts = Product::getTopCheapProducts();
        $mostDiscountProducts = Product::getTopDiscountedProducts();

        return response()->success('', compact('categories','searchProducts','mostViewedProducts','topPriceProducts','topCheapProducts','mostDiscountProducts','lastProducts'));
    }
    
    public function show($id): JsonResponse
    {
        $product = Product::with('categories:id,title', 'specifications:id,name','colors:id,title,code')
                ->selectRaw('*, (price - discount) as final_price')
                ->findOrFail($id);

            $comments = Comment::where('product_id', $product->id)->where('status','accepted')->avg('star')->get();
        
        $moreProducts = $product->categories()->get()->flatMap(function ($category) {
            return $category->products;
        });
        views($product)->record();
        
        return response()->success("مشخصات محصول {$product->id}",compact('product','comments','moreProducts'));
    }
}
