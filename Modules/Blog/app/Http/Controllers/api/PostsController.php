<?php

namespace Modules\Blog\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        $postCategories = BlogCategory::select('id', 'title')
        ->with('posts')
        ->when($request->has('category_id'), function ($query) use ($request) {
            return $query->where('id', $request->category_id);
        })
        ->when($request->has('title'), function ($query) use ($request) {
            $query->whereHas('posts', function ($subQuery) use ($request) {
                $subQuery->where('title', 'like', '%' . $request->input('title') . '%');
            });
        })
        ->paginate();

        $featuredPosts = Post::query()
        ->select('id','title','summary','body','featured','created_at')
        ->where('featured',1 && 'status',1)
        ->take(4)
        ->latest('id')
        ->get();

        // حذف 4 پست اول از نتایج
        $postsToSkip = count($featuredPosts);

        // گرفتن 12 پست بعدی که از 4 پست اول حذف شده باشند
        $lastPosts = Post::query()
        ->select('id','title','summary','body','created_at')
        ->where('status',1)
        ->skip($postsToSkip)
        ->latest('id')
        ->paginate(12);

        return response()->success('', compact('featuredPosts','lastPosts','postCategories'));
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
