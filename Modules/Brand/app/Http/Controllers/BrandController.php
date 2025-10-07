<?php

namespace Modules\Brand\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Brand\Http\Requests\StoreRequest;
use Modules\Brand\Models\Brand;
use Modules\Product\Models\Category;

class BrandController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view brands',['index','show']),
            new Middleware('can:create brands',['create','store']),
            new Middleware('can:edit brands',['edit','update']),
            new Middleware('can:delete brands',['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    private function getChildren($categories, array $allCategories, $i)
    {
        foreach ($categories as $category) {
            $i++;
            $allCategories[$category->id] = str_repeat('-', $i) . $category->title;
            if ($category->recursiveChildren->isNotEmpty()) {
                $allCategories = $this->getChildren($category->recursiveChildren, $allCategories, $i);
            }
        }

        return $allCategories;
    }
    public function sort(Request $request): RedirectResponse
    {
        Brand::setNewOrder($request->brands);

        return redirect()->back()
        ->with('success', 'ایتم ها با موفقیت مرتب شد.');
    }
    public function index()
    {
        $brands = Brand::select('id','title','description','status','order')->with('categories:id,title')->orderBy('order', 'asc')->paginate();
        $categories = Category::query()
        ->latest('id')
        ->whereNull('parent_id')
        ->select('id', 'title')
        ->with('recursiveChildren:id,title,parent_id')
        ->get();
        $allCategories = [];
        $i = 0;
        foreach ($categories as $category) {
            $allCategories[$category->id] = $category->title;
            if ($category->recursiveChildren->isNotEmpty()) {
                $allCategories = $this->getChildren($category->recursiveChildren, $allCategories, $i);
            }
        }
        
        return view('brand::admin.index',compact('brands','allCategories'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $brand = Brand::query()->create([
            'status' => filled($request->status) ?: 0,
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);
        $brand->uploadFiles($request);
        $categories = $request->categories;
        foreach ($categories as $category) {
            $brand->categories()->attach($category);
        }

        $data = [
            'status' => 'success',
            'message' => 'برند با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.brands.index')
        ->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Brand $brand): RedirectResponse
    {
        $brand->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => filled($request->status) ?: 0,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);
        $brand->uploadFiles($request);

        $categories = $request->categories;

        $brand->categories()->detach();
        foreach ($categories as $category) {
            $brand->categories()->attach($category);
        }
        $data = [
            'status' => 'success',
            'message' => 'برند با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.brands.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        $data = [
            'status' => 'success',
            'message' => 'برند با موفقیت حذف شد'
        ];

        return redirect()->route('admin.brands.index')
            ->with($data);
    }
}