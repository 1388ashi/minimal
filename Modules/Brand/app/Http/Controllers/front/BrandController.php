<?php

namespace Modules\Brand\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Brand\Models\Brand;

class BrandController extends Controller implements HasMiddleware
{
    public function index()
    {
        $brands = Brand::select('id','title','status','description')->get();
        
        return response()->success('',compact('brands'));
    }
    public function show(Brand $brand)
    {
        return response()->success('',compact('brand'));
    }
}