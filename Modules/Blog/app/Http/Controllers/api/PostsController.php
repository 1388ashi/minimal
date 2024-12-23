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

        $postCategories = Post::select('id','title','summary','body','type','featured','category_id','created_at')
        ->with('category:id,title')
        ->when($request->has('category_id'), function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->when($request->has('title'), function ($query) use ($request) {
            return $query->where('title', 'like', '%'. $request->input('title'). '%');
        })
        ->paginate();

        $categories  = BlogCategory::select('id','title','type')->with('posts')->where('status',1)->get();

        $featuredPosts = Post::query()  
        ->select('id', 'title', 'summary', 'type', 'body', 'featured', 'created_at')  
        ->where('featured', 1)  
        ->where('status', 1)  
        ->take(4)  
        ->latest('id')  
        ->get(); 

        $postsToSkip = count($featuredPosts);
        dd($postsToSkip);  

        $lastPosts = Post::query()  
        ->select('id', 'title', 'summary', 'body', 'type', 'created_at')  
        ->where('status', 1)  
        ->latest('id')  
        ->skip($postsToSkip)  
        ->toSql();  

        return response()->success('', compact('featuredPosts','lastPosts','postCategories','categories'));
    }

    public function show(Request $request,$id): JsonResponse
    {
        $post = Post::select('id','title','writer','read','type','category_id','body','summary','created_at')
        ->with('category:id,title')->where('status',1)->findOrFail($id);

        $searchPost = Post::query()
        ->select('id','title','writer','read','type','category_id','body','summary','created_at')
        ->when($request->has('title'), function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        })
        ->with('category:id,title')
        ->where('status',1)
        ->latest('id')
        ->paginate(12);
        views($post)->record();

        $viewCount = views($post)->count();
        $mostViewedPosts = Post::orderByViews()->with('category:id,title')->take(4)->get();
        $categories = BlogCategory::select('id','title')->with('posts:id,title,summary,body,featured,created_at')->where('type',$post->type)->take(5)->get();
        $morePosts = Post::select('id','title','writer','read','type','category_id','body','summary','created_at')->where('category_id',$post->category_id)->take(10)->get();

        return response()->success("مشخصات بلاگ {$post->id}",compact('post','searchPost','viewCount','mostViewedPosts','categories','morePosts'));
    }
}
