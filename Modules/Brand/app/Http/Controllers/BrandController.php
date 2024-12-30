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
    public function index()
    {
        $brands = Brand::select('id','title','description','status')->latest('id')->paginate();
        
        return view('brand::admin.index',compact('brands'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $brand = Brand::query()->create([
            'status' => filled($request->status) ?: 0,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $brand->uploadFiles($request);
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
            'status' => filled($request->status) ?: 0,
            'description' => $request->description,
        ]);
        $brand->uploadFiles($request);
        
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