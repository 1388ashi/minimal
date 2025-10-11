<?php

namespace Modules\Blog\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Blog\Models\BlogCategory;
use Modules\Blog\Models\Post;

class PostsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categoryId = $request->query("category_id");

        $categories  = BlogCategory::select('id','title')->where('status',1)->get();

        $articlePosts = Post::query()  
            ->select('id', 'title','slug','category_id','summary','status', 'type','created_at','image_alt')  
            ->where('type', 'article')  
            ->where('status', 1)  
            ->when($categoryId, fn ($q) => $q->where('category_id',$categoryId))
            ->take(8)  
            ->latest('id')  
            ->get(); 
        
        $trendPosts = Post::query()  
            ->select('id', 'title','slug','category_id','status', 'summary', 'type', 'created_at','image_alt')  
            ->where('status', 1)  
            ->where('type', 'trend')
            ->take(6)  
            ->latest('id')  
            ->get();  

        return response()->success('', compact('articlePosts','categories','trendPosts'));
    }

    public function show(Request $request,$slug): JsonResponse
    {
        $post = Post::with('productCategories:id,title,slug')->select('id','title','category_id','body','slug','image_alt')
            ->where('status',1)->where('slug',$slug)->firstOrFail();
        $productCategories = $post->productCategories->makeHidden(['dark_image']);
        unset($post->productCategories);
        $morePosts = Post::select('id','title','category_id','summary','created_at','slug','image_alt')
            ->where('category_id',$post->category_id)->take(10)->get();
        

        return response()->success("مشخصات بلاگ {$post->id}",compact('post','morePosts','productCategories'));
    }
}
