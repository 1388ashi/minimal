<?php

namespace Modules\Menu\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Brand\Models\Brand;
use Modules\Product\Models\Category;

class MenuController extends Controller
{
  public function index(){
    $brands = Brand::select('id', 'title', 'status', 'description')->orderBy('order', 'asc')->get();
    foreach ($brands as $brand) {
        $brand['link']  = 'https://minimalzee.ir/brands/' . $brand->id; 
    }
    $productCategories = Category::select('id','title','parent_id')
        ->where('status',1)
        ->whereNull('parent_id')
        ->with(['children:id,title,parent_id'])
        ->get();
    foreach ($productCategories as $item) {
        $item['link']  = 'https://minimalzee.ir/products?category_id=' . $item->id; 
    }
    
    $menus = [
       [
        'link' => 'https://minimalzee.ir/',
        'title' => 'مینیمال زی'
       ],
       [
           'link' => 'https://minimalzee.ir/brands/',
            'title' => 'برند ها',
            'children' => $brands 
        ],
        [
            'link' => 'https://minimalzee.ir/categories/',
            'title' => 'محصولات',
            'children' => $productCategories 
        ],
        [
            'link' => 'https://minimalzee.ir/weblog/',
            'title' => 'بلاگ'
        ],
        [
            'link' => 'https://minimalzee.ir/about-us/',
            'title' => 'درباره ما'
        ],
    ];

    return response()->success('',compact('menus'));
  }
}
