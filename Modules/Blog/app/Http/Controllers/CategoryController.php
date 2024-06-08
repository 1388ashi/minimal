<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Blog\Http\Requests\Category\StoreRequest;
use Modules\Blog\Models\BlogCategory;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view categories',['index','show']),
            new Middleware('can:create categories',['create','store']),
            new Middleware('can:edit categories',['edit','update']),
            new Middleware('can:delete categories',['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
        $blog_categories = BlogCategory::query()
                    ->select('id','title','type','status','created_at')
                    ->latest('id')
                    ->paginate(15);
                    
        return view('blog::admin.category.index', compact('blog_categories'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blog_categories = BlogCategory::query()
                    ->select('id','title','type','status','created_at')
                    ->paginate();
                    
        return view('blog::admin.category.index', compact('blog_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        BlogCategory::query()->create([
            'title' => $request->title,
            'type' => $request->type,
            'status' => filled($request->status) ?: 0
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'دسته بندی با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.blog-categories.index')
        ->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategory $blog_category,StoreRequest $request): RedirectResponse
    {
        $blog_category->update([
            'title' => $request->title,
            'type' => $request->type,
            'status' => filled($request->status) ?: 0
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'دسته بندی با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.blog-categories.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blog_category)
    {
        if ($blog_category->posts) {
            $data = [
                'status' => 'danger',
                'message' => 'دسته بندی به پستی وصل هست'
            ];
            return redirect()->route('admin.blog-categories.index')->with($data);
        }
        $blog_category->delete();

        $data = [
            'status' => 'success',
            'message' => 'دسته بندی با موفقیت حذف شد'
        ];

        return redirect()->route('admin.blog-categories.index')
                ->with($data);
    }
}
