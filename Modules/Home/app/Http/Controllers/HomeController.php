<?php

namespace Modules\Home\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\About\Models\AboutUs;
use Modules\Blog\Models\BlogCategory;
use Modules\Blog\Models\Post;
use Modules\Brand\Models\Brand;
use Modules\CustomerReview\Models\CustomerReview;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;
use Modules\Slider\Models\Slider;
use Modules\WorkSample\Models\WorkSample;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(Request $request): JsonResponse
    {
        $upSliders = Slider::query()->where('status',1)->where('type','up')
            ->select('id','title','link','status','type')->latest('id')->take(4)->get();
        $downSliders = Slider::query()->where('status',1)->where('type','down')
            ->select('id','title','link','status','type')->latest('id')->take(4)->get();
        $posts = Post::select('id','title','writer','created_at','slug','image_alt')->where('status',1)->latest('id')->take(4)->get();
        $brands = Brand::select('id','status','order','slug')->where('status',1)->orderBy('order', 'asc')->get()->makeHidden(['white_image','background']);
        $categories = Category::query()->select('id','title','parent_id','slug','status')
            ->where('status',1)->whereNull('parent_id')->take(8)->get()->makeHidden(['dark_image']);  
       
        $aboutUs = AboutUs::pluck('text', 'name');

        return response()->success('',compact('categories','upSliders','downSliders','aboutUs','brands','posts'));
    }
    public function menus(){
        $brands = Brand::select('id', 'title', 'status','slug')->orderBy('order', 'asc')->get()->makeHidden(['background']);
        foreach ($brands as $brand) {
            $brand['link']  = '/brands/' . $brand->slug; 
        }
        $productCategories = Category::select('id','title','parent_id','slug')
            ->where('status',1)
            ->whereNull('parent_id')
            ->with(['children:id,title,parent_id'])
            ->get()
            ->makeHidden(['image']);
        foreach ($productCategories as $item) {
            $item['link'] = '/products?category_id=' . $item->id; 
            foreach ($item->children as $child) {
                $child->makeHidden(['image','dark_image']);
                $child['link'] = '/products?category_id=' . $child->id; 
            }
        }
        
        $menus = [
            [
                'link' => '/',
                'title' => 'مینیمال زی',
                'children' => [],
                'group' => 'general'
            ],
            [
                'link' => '/brands/',
                'title' => 'برند ها',
                'children' => $brands,
                'group' => 'brands'
            ],
            [
                'link' => '/categories/',
                'title' => 'محصولات',
                'children' => $productCategories,
                'group' => 'products'
            ],
            [
                'link' => '/weblog/',
                'title' => 'بلاگ',
                'children' => [],
                'group' => 'general'
            ],
            [
                'link' => '/about-us/',
                'title' => 'درباره ما',
                'children' => [],
                'group' => 'general'
            ],
        ];

        return response()->success('',compact('menus'));
    }
}
