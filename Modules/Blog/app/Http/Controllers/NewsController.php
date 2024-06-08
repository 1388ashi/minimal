<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Blog\Http\Requests\Blog\StoreRequest;
use Modules\Blog\Http\Requests\Blog\UpdateRequest;
use Modules\Blog\Models\BlogCategory;
use Modules\Blog\Models\Post;

class NewsController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view blogs',['index','show']),
            new Middleware('can:create blogs',['create','store']),
            new Middleware('can:edit blogs',['edit','update']),
            new Middleware('can:delete blogs',['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
        $news = Post::filters(request()->query())
                ->select('id','title','summary','type','featured','status','created_at','category_id')
                ->where('type','news')
                ->with('category:id,title')
                ->latest('id')
                ->paginate(15);
        $filterInputs = Post::getFilterInputs();

        return view('blog::admin.news.index', compact('news','filterInputs'));
    }
            
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::select('id','title','type')->where('type','news')->get();

        return view('blog::admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $published_at = $request->published_at;
        if (!filled($published_at)) {
            $published_at = now();
        }
        $news = Post::query()->create([
            'title' => $request->title,
            'writer' => $request->writer,
            'type' => 'news',
            'category_id' => $request->category_id,
            'summary' => $request->summary,
            'body' => $request->body,
            'published_at' => $published_at,
            'featured' => filled($request->featured) ?: 0,
            'status' => filled($request->status) ?: 0
        ]);
        $news->uploadFiles($request);
        
        $data = [
            'status' => 'success',
            'message' => 'خبر با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.news.index')
        ->with($data);
    }

    /**
     * Show the specified resource.
     */
    public function show(Post $news)
    {
        $news->load(['category:id,title']);

        return view('blog::admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $news)
    {
        $categories = BlogCategory::select('id','title','type')->where('type','news')->get();
        
        return view('blog::admin.news.edit', compact('news','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $news,UpdateRequest $request): RedirectResponse
    {
        $published_at = $request->published_at;
        if (!filled($published_at)) {
            $published_at = now();
        }
        $news->update([
            'title' => $request->title,
            'writer' => $request->writer,
            'type' => 'news',
            'category_id' => $request->category_id,
            'summary' => $request->summary,
            'body' => $request->body,
            'published_at' => $published_at,
            'featured' => filled($request->featured) ?: 0,
            'status' => filled($request->status) ?: 0
        ]);
        $news->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'خبر با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.news.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $news)
    {
        $news->delete();

        $data = [
            'status' => 'success',
            'message' => 'خبر با موفقیت حذف شد'
        ];

        return redirect()->route('admin.news.index')
                ->with($data);
    }
}
