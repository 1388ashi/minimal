<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Product\Http\Requests\Category\StoreRequest;
use Modules\Product\Http\Requests\Category\UpdateRequest;
use Modules\Product\Models\Category;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view products',['index','show']),
            new Middleware('can:create products',['create','store']),
            new Middleware('can:edit products',['edit','update']),
            new Middleware('can:delete products',['destroy']),

        ];
    }
    public function index(): Renderable
    {
        $categories = Category::query()
        ->with(['parent:id,title','recursiveChildren:id,title,parent_id'])
        ->latest('id')
        ->paginate();

        return view('product::admin.category.index', compact('categories'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::query()
        ->latest('id')
        ->whereNull('parent_id')
        ->select('id','title')
        ->with('children:id,title,parent_id','recursiveChildren:id,title,parent_id')
        ->get();
        
        return view('product::admin.category.create', compact('parents'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $category = Category::query()->create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'parent_id' => $request->input('parent_id'),
            'featured' => filled($request->featured) ?: 0,
            'status' => filled($request->status) ?: 0
        ]);
        $category->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'دسته بندی با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.categories.index')
        ->with($data);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parents = Category::query()
        ->latest('id')
        ->whereNot('id',$category->id)
        ->whereNull('parent_id')
        ->select('id','title')
        ->with(['children' => function ($query) use($category) {
            $query->select('id', 'title', 'parent_id')
                ->whereNot('id',$category->id);
        }, 'recursiveChildren' => function ($query) use($category) {
            $query->select('id', 'title', 'parent_id')
                ->whereNot('id',$category->id);
        }])
        ->get();

        return view('product::admin.category.edit', compact('parents','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request,Category $category)
    {
        $category->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'parent_id' => $request->input('parent_id'),
            'featured' => filled($request->featured) ?: 0,
            'status' => filled($request->status) ?: 0
        ]);
        $category->uploadFiles($request);
        
        $data = [
            'status' => 'success',
            'message' => 'دسته بندی با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.categories.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyImage(Category $category)
    {
        $mediaId = $category->media->first()->delete();
        $category->save();

        $data = [
            'status' => 'success',
            'message' => 'تصویر دسته بندی با موفقیت حذف شد '
        ];

        return redirect()->route('admin.categories.index')
            ->with($data);
    }
    public function destroy(Category $category)
    {
        if ($category->products->isNotEmpty() || $category->children->isNotEmpty()) {
            $data = [
                'status' => 'danger',
                'message' => 'دسته بندی قابل حذف نمی باشد '
            ];
            return redirect()->route('admin.categories.index')->with($data);
        }
        $category->delete();

        $data = [
            'status' => 'success',
            'message' => 'دسته بندی با موفقیت حذف شد'
        ];

        return redirect()->route('admin.categories.index')
            ->with($data);
    }
}
