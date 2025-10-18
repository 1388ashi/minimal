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
            ->select('id', 'title','slug','title_page','category_id','summary','meta_description','status', 'type','created_at','image_alt','robots')  
            ->where('type', 'article')  
            ->where('status', 1)  
            ->when($categoryId, fn ($q) => $q->where('category_id',$categoryId))
            ->take(8)  
            ->latest('id')  
            ->get(); 
        
        $trendPosts = Post::query()  
            ->select('id', 'title','slug','title_page','category_id','status', 'summary', 'type', 'created_at','image_alt','robots')  
            ->where('status', 1)  
            ->where('type', 'trend')
            ->take(6)  
            ->latest('id')  
            ->get();  

        return response()->success('', compact('articlePosts','categories','trendPosts'));
    }

    public function show(Request $request,$slug): JsonResponse
    {
        $post = Post::with('productCategories:id,title,slug')->select('id','title_page','title','category_id','meta_description','body','slug','image_alt','robots','canonical_tag')
            ->where('status',1)->where('slug',$slug)->firstOrFail();
        $productCategories = $post->productCategories->makeHidden(['dark_image']);
        unset($post->productCategories);
        $morePosts = Post::select('id','title','category_id','summary','created_at','slug','image_alt','title_page','meta_description')
            ->where('category_id',$post->category_id)->take(10)->get();
        

        return response()->success("مشخصات بلاگ {$post->id}",compact('post','morePosts','productCategories'));
    }
}
