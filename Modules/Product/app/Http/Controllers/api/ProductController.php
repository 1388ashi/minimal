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

        $brands = Brand::select('id', 'title','slug')
            ->latest('id')
            ->get()
            ->makeHidden(['white_image', 'dark_image', 'background']);
        $categories = Category::select('id','title','parent_id','slug')
        ->where('status',1)
        ->whereNull('parent_id')
        ->with(['children:id,title,parent_id,slug'])
        ->get()
        ->makeHidden(['dark_image','image']);
        $categories->each(function($product) {
            $product->children->each->makeHidden(['dark_image', 'image']);
        });

        $products = Product::query()
            ->select('id','title','slug','image_alt','brand_id','status','robots','canonical_tag')
            ->whereHas('categories', function($query) {
                $query->where('status', 1);
            })
            ->when($request->has('category_id'), function ($query) use ($request) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('category_id', $request->input('category_id'))->with(['children:id,title,parent_id']);
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
            ->with('categories:id,title,parent_id,slug')
            ->where('status',1)
            ->latest('id')
            ->paginate(20);
        $products->getCollection()->each->makeHidden(['video']);
        $products->getCollection()->each(function($product) {
            $product->categories->each->makeHidden(['dark_image', 'image']);
        });
        
        return response()->success('', compact('products','categories','brands'));
    }

//    public function show($slug): JsonResponse
//     {
//         $product = Product::with('categories:id,title', 'specifications:id,name','colors:id,title,code')
//                 ->selectRaw('*, (price - discount) as final_price')
//                 ->where('slug',$slug)->firstOrFail();

//         $averageStar = Comment::where('product_id', $product->id)
//         ->where('status', 'accepted')
//         ->avg('star');

//         $comments = Comment::where('product_id',$product->id)
//         ->where('status', 'accepted')
//         ->get();

//         $moreProducts = $product->categories()->get()->flatMap(function ($category) use ($product) {
//             $categoryProducts = $category->products->map(function ($product) {
//                 $product->setAttribute('final_price', $product->totalPriceWithDiscount());
//                 return $product;
//             });

//             return $categoryProducts;
//         });

//         views($product)->record();

//         return response()->success("مشخصات محصول {$product->id}",compact('product','comments','moreProducts','averageStar'));
//     }
   public function show(Request $request,$slug): JsonResponse
    {
       $sortBy = $request->sortBy;
        $category = Category::where('slug',$slug)->first();
        $brands = Brand::select('id', 'title','slug')
            ->latest('id')
            ->get()
            ->makeHidden(['white_image', 'dark_image', 'background']);
        $categories = Category::select('id','title','parent_id','slug')
        ->where('status',1)
        ->whereNull('parent_id')
        ->with(['children:id,title,parent_id,slug'])
        ->get()
        ->makeHidden(['dark_image','image']);
        $categories->each(function($product) {
            $product->children->each->makeHidden(['dark_image', 'image']);
        });

        $products = Product::query()
            ->select('id','title','slug','image_alt','brand_id','status','robots','canonical_tag')
            ->whereHas('categories', function($query) use ($category) {
                $query->where('status', 1);
                if ($category) {
                    $query->where('id', $category->id);
                }
            })
            ->when($request->has('category_id'), function ($query) use ($request) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('category_id', $request->input('category_id'))->with(['children:id,title,parent_id']);
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
            ->with('categories:id,title,parent_id,slug')
            ->where('status',1)
            ->latest('id')
            ->paginate(20);
        $products->getCollection()->each->makeHidden(['video']);
        $products->getCollection()->each(function($product) {
            $product->categories->each->makeHidden(['dark_image', 'image']);
        });
        
        return response()->success('', compact('products','categories','brands'));
    }
}
