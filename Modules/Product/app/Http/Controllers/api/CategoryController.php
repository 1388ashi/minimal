<?php

namespace Modules\Product\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id','title','parent_id','slug')
        ->where('status',1)
        ->whereNull('parent_id')
        ->get()
        ->makeHidden(['dark_image']);

        return response()->success('', compact('categories'));
    }
}
