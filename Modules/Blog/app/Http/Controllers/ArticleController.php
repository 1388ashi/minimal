<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Blog\Http\Requests\Blog\StoreRequest;
use Modules\Blog\Http\Requests\Blog\UpdateRequest;
use Modules\Blog\Models\Post;
use Modules\Blog\Models\BlogCategory;

class ArticleController extends Controller implements HasMiddleware
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
        $articles = Post::filters(request()->query())
                ->select('id','title','summary','type','featured','status','created_at','category_id')
                ->where('type','article')
                ->with('category:id,title')
                ->latest('id')
                ->paginate(15);        
        $filterInputs = Post::getFilterInputs();

        return view('blog::admin.articles.index', compact('articles','filterInputs'));
    }
            
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::select('id','title','type')->where('type','article')->get();

        return view('blog::admin.articles.create', compact('categories'));
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
        $article = Post::query()->create([
            'title' => $request->title,
            'writer' => $request->writer,
            'read' => $request->read,
            'type' => 'article',
            'category_id' => $request->category_id,
            'summary' => $request->summary,
            'body' => $request->body,
            'published_at' => $published_at,
            'featured' => filled($request->featured) ?: 0,
            'status' => filled($request->status) ?: 0
        ]);
        $article->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'مقاله با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.articles.index')
        ->with($data);
    }

    /**
     * Show the specified resource.
     */
    public function show(Post $article)
    {
        $article->load(['category:id,title']);

        return view('blog::admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $article)
    {
        $categories = BlogCategory::select('id','title','type')->where('type','article')->get();
        
        return view('blog::admin.articles.edit', compact('article','categories'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Post $article,UpdateRequest $request): RedirectResponse
    {
        $published_at = $request->published_at;
        if (!filled($published_at)) {
            $published_at = now();
        }
        $article->update([
            'title' => $request->title,
            'type' => 'article',
            'writer' => $request->writer,
            'category_id' => $request->category_id,
            'summary' => $request->summary,
            'read' => $request->read,
            'body' => $request->body,
            'published_at' => $published_at,
            'featured' => filled($request->featured) ?: 0,
            'status' => filled($request->status) ?: 0
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'مقاله با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.articles.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $article)
    {
        $article->delete();

        $data = [
            'status' => 'success',
            'message' => 'مقاله با موفقیت حذف شد'
        ];

        return redirect()->route('admin.articles.index')
                ->with($data);
    }
}
