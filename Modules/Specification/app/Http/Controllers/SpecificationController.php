<?php

namespace Modules\Specification\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Product\Models\Category;
use Modules\Specification\Http\Requests\StoreRequest;
use Modules\Specification\Http\Requests\UpdateRequest;
use Modules\Specification\Models\Specification;

class SpecificationController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view specificaions',['index','show']),
            new Middleware('can:create specificaions',['create','store']),
            new Middleware('can:edit specificaions',['edit','update']),
            new Middleware('can:delete specificaions',['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specifications = Specification::query()->with('categories:id,title')->latest('id')->paginate();
        $categories = Category::query()
        ->latest('id')
        ->whereNull('parent_id')
        ->select('id','title')
        ->with('children:id,title,parent_id','recursiveChildren:id,title,parent_id')
        ->get();

        return view('specification::admin.index', compact('specifications','categories'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specifications = Specification::query()->with('categories:id,title')->latest('id')->paginate();
        $categories = Category::query()
        ->latest('id')
        ->whereNull('parent_id')
        ->select('id','title')
        ->with('children:id,title,parent_id','recursiveChildren:id,title,parent_id')
        ->get();

        
        return view('specification::admin.index',compact('categories','specifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $specification = Specification::query()->create([
            'name' => $request->input('name'),
        ]);
        $specification->categories()->attach($request->input('categories'));
        $data = [
            'status' => 'success',
            'message' => 'مشخصات با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.specifications.index')
        ->with($data);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specification $specification)
    {
        $categories = Category::query()
        ->latest('id')
        ->whereNull('parent_id')
        ->select('id','title')
        ->with('children:id,title,parent_id','recursiveChildren:id,title,parent_id')
        ->get();

        
        return view('specification::admin.edit',compact('categories','specification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Specification $specification)
    {
        $specification->update(['name' => $request->input('name')]);
        $specification->categories()->sync($request->input('categories'));

        $data = [
            'status' => 'success',
            'message' => 'مشخصات با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.specifications.index')
        ->with($data);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specification $specification)
    {
        $specification->delete();
        
        $data = [
            'status' => 'success',
            'message' => 'مشخصات با موفقیت حذف شد'
        ];
        
        return redirect()->route('admin.specifications.index')
        ->with($data);
    }
}
