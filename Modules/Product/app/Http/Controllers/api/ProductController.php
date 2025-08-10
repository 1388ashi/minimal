<?php

namespace Modules\Product\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Brand\Models\Brand;
use Modules\Comment\Models\Comment;
use Modules\Product\Models\Category;
use Modules\Product\Models\Color;
use Modules\Product\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $sortBy = $request->sortBy;

        $brands = Brand::select('id','title')->latest('id')->get();
        $colors = Color::select('id','title','code')->latest('id')->get();
        $categories = Category::select('id','title','parent_id')
        ->where('status',1)
        ->whereNull('parent_id')
        ->with(['children:id,title,parent_id'])
        ->get();

        $products = Product::query()
        ->whereHas('categories', function($query) {
            $query->where('status', 1);
        })
        ->when($request->has('category_id'), function ($query) use ($request) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->input('category_id'))->with(['children:id,title,parent_id']);
            });
        })
        ->when($request->has('color_id'), function ($query) use ($request) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->where('color_id', $request->input('color_id'));
            });
        })
        ->when($request->has('brand_id'), function ($query) use ($request) {
            $query->where('brand_id', $request->input('brand_id'));
        })
        ->when($request->has('title'), function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        })
        ->when($request->has('min_price') && $request->has('max_price'), function ($query) use ($request) {
            $query->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
        })
        ->when($sortBy, function ($query) use ($sortBy) {
            if ($sortBy == 'mostViewed') {
                return $query->orderByViews()->latest('id');
            } elseif ($sortBy == 'topPrice') {
                return $query->orderByDesc('price');
            } elseif ($sortBy == 'topCheap') {
                return $query->orderBy('price', 'ASC');
            } elseif ($sortBy == 'mostDiscount') {
                return $query->where('discount','!=','0')->orderByDesc('discount');
            } elseif ($sortBy == 'lastProducts') {
                return $query->latest('id');
            }
        })
        ->with('categories:id,title,parent_id')
        ->withCount('views')
        ->where('status',1)
        ->paginate(20);
        
        $products->map(function ($product) {
            return $product->setAttribute('final_price', $product->totalPriceWithDiscount());
        });
        $topPrice = Product::orderByDesc('price')->value('price');

        return response()->success('', compact('products','categories','colors','topPrice','brands'));
    }

   public function show($id): JsonResponse
    {
        $product = Product::with('categories:id,title', 'specifications:id,name','colors:id,title,code')
                ->selectRaw('*, (price - discount) as final_price')
                ->findOrFail($id);

        $averageStar = Comment::where('product_id', $id)
        ->where('status', 'accepted')
        ->avg('star');

        $comments = Comment::where('product_id',$id)
        ->where('status', 'accepted')
        ->get();

        $moreProducts = $product->categories()->get()->flatMap(function ($category) use ($product) {
            // اینجا شما می‌توانید قیمت نهایی را برای هر محصول مشخص کنید
            $categoryProducts = $category->products->map(function ($product) {
                $product->setAttribute('final_price', $product->totalPriceWithDiscount());
                return $product;
            });

            return $categoryProducts;
        });

        views($product)->record();

        return response()->success("مشخصات محصول {$product->id}",compact('product','comments','moreProducts','averageStar'));
    }
}
