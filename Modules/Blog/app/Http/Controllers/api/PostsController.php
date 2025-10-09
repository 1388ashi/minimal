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

        $postCategories = Post::select('id','title','summary','body','type','featured','category_id','created_at','slug','image_alt')
        ->with('category:id,title')
        ->when($request->has('category_id'), function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->when($request->has('title'), function ($query) use ($request) {
            return $query->where('title', 'like', '%'. $request->input('title'). '%');
        })
        ->paginate();

        $categories  = BlogCategory::select('id','title')->with('posts')->where('status',1)->get();

        $articlePosts = Post::query()  
        ->select('id', 'title', 'summary', 'type', 'body', 'featured', 'created_at','image_alt')  
        ->where('type', 'article')  
        ->where('status', 1)  
        ->take(7)  
        ->latest('id')  
        ->get(); 

        $postsToSkip = count($articlePosts);

        $newsPosts = Post::query()  
        ->select('id', 'title', 'summary', 'body', 'type', 'created_at','image_alt')  
        ->where('status', 1)  
        ->latest('id')  
        ->where('type','news')  
        ->skip($postsToSkip)  
        ->paginate();  
        
        $trendPosts = Post::query()  
        ->select('id', 'title', 'summary', 'body', 'type', 'created_at','image_alt')  
        ->where('status', 1)  
        ->where('type', 'trend')
        ->take(6)  
        ->latest('id')  
        ->get();  

        return response()->success('', compact('articlePosts','newsPosts','postCategories','categories','trendPosts'));
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
