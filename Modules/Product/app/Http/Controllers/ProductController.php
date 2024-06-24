<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Product\Http\Requests\Product\StoreRequest;
use Modules\Product\Http\Requests\Product\UpdateRequest;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;
use Modules\Product\Models\Color;
use Modules\Specification\Models\Specification;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view products',['index','show']),
            new Middleware('can:create products',['create','store']),
            new Middleware('can:edit products',['edit','update']),
            new Middleware('can:delete products',['destroy']),

        ];
    }
    public function getSpecifications(Request $request){
        $productId = $request->productId;
        $categoryIds = $request->input('categoryIds');
        $categories = Category::whereIn('id', $categoryIds)->get();

        $specifications = collect([]);
        foreach ($categories as $category) {
            if ($category) {
                $specifications = $specifications->merge($category->specifications);
            }
        }
        $product = null;
        if ($productId) {
            $product = Product::find($productId);
            $product->load('specifications');
        }

        $data = [];
        $specifications = $specifications->unique('id');
        foreach ($specifications as $specification) {
            $data[] = [
                'id' => $specification->id,
                'name' => $specification->name,
                'value' => $product && $product->specifications->isNotEmpty() && $product->specifications->where('id', $specification->id)->first() ? $product->specifications->where('id', $specification->id)->first()->pivot->value : null
            ];
        }

        return response()->json(['specifications' => $data]);
    }
    public function index(): Renderable
    {
        $categories = Category::select(["id","title"])->get();

        $title = request('title');
        $categoryId = request('category_id');
        $discount = request('discount');
        $status = request('status');

        $products = Product::query()
        ->select('id','title','price','discount','status')
        ->when($title, fn ($query) => $query->where('title', 'like', "%$title%"))
        ->when($categoryId, function ($query) use ($categoryId) {
            return $query->whereHas('categories', function($q) use ($categoryId) {
                return $q->where('categories.id', $categoryId);
            });
        })
        ->when($discount, function ($query) use ($discount) {
            if ($discount == '1') {
                return $query->whereNotNull('discount');
            }else {
                return $query->whereNull('discount');
            }
        })
        ->when(isset($status), fn ($query) => $query->where("status", $status))
        ->with('categories:id,title')
        ->latest('id')
        ->paginate(15);

        return view('product::admin.product.index', compact('products','categories'));
    }
    public function show(Product $product) {

        $product->load([
            'categories:id,title',
            'specifications:id,name',
            'colors:id,title,code'
        ]);

        return view('product::admin.product.show', compact('product'));

    }
    public function create(): Renderable
    {
        $colors = Color::select('id','title','code')->latest('id')->get();

        $categories = Category::query()
        ->latest('id')
        ->whereNull('parent_id')
        ->select('id','title')
        ->with('children:id,title,parent_id','recursiveChildren:id,title,parent_id')
        ->get();

        return view('product::admin.product.create', compact('categories','colors'));
    }
    public function store(StoreRequest $request)
    {
        $product = Product::create($request->validated());
        $product->uploadFiles($request);

        $specifications = $request->specifications;
        if(!is_null($specifications)){
        foreach($specifications as $id => $value) {
            if(!empty($value)){
                $product->specifications()->attach($id, ['value' => $value]);
            }
        }
        }

        $categories = $request->categories;
        foreach($categories as $category) {
            $product->categories()->attach($category);
        }

        $colors = $request->colors;
        if(!is_null($colors)){
            foreach($colors as $color) {
                $product->colors()->attach($color);
            }
        }

        $data = [
            'status' => 'success',
            'message' => 'محصول با موفقیت ثبت شد'
        ];

        return redirect()->route('admin.products.index')
        ->with($data);
    }

    public function edit(Product $product): Renderable
    {
        $product = $product->load('specifications');

        $colors = Color::select('id','title','code')->latest('id')->get();
        $categories = Category::query()
        ->latest('id')
        ->whereNull('parent_id')
        ->select('id','title')
        ->with('children:id,title,parent_id','recursiveChildren:id,title,parent_id')
        ->get();

        $specifications = [];
        foreach ($product->specifications as $specification) {
            $specifications[] = collect([
                'id' => $specification->id,
                'name' => $specification->name,
                'value' => $product? $product->specifications->where('id', $specification->id)->first()->pivot->value : null
            ]);
        }

        return view('product::admin.product.edit', compact('categories','product', 'specifications','colors'));
    }
    public function update(UpdateRequest $request, Product $product)
    {
            $product->update($request->validated());
            $product->uploadFiles($request);

            $product->specifications()->detach();
            $specifications = $request->specifications;

            if(filled($specifications)){
                foreach($specifications as $id => $value) {
                    if(!empty($value)){
                        $product->specifications()->attach($id, ['value' => $value]);
                    }
                }
            }

            $categories = $request->categories;

            $product->categories()->detach();
            foreach($categories as $category) {
                $product->categories()->attach($category);
            }

            $colors = $request->colors;
            $product->colors()->detach(); // حذف همه اتصالات قبلی
            if(!is_null($colors)){
                foreach($colors as $color) {
                    $product->colors()->attach($color);
                }
            }
            $data = [
                'status' => 'success',
                'message' => 'محصول با موفقیت به روزرسانی شد'
            ];

            return redirect()->route('admin.products.index')
            ->with($data);

    }
    public function destroyGalleries($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();

        $data = [
            'status' => 'success',
            'message' => 'تصویر محصول با موفقیت حذف شد '
        ];

        return redirect()->route('admin.products.index')
            ->with($data);
    }
    public function destroyVideo(Product $product)
    {
        $mediaId = $product->video['id'];
        $product->media->find($mediaId)->delete();
        $product->save();

        $data = [
            'status' => 'success',
            'message' => 'ویدیو محصول با موفقیت حذف شد '
        ];

        return redirect()->route('admin.products.index')
            ->with($data);
    }

    // // /**
    // //  * Remove the specified resource from storage.
    // //  */
    public function destroy(Product $product)
    {
        $product->delete();
        $data = [
            'status' => 'success',
            'message' => 'محصول با موفقیت حذف شد'
        ];

        return redirect()->route('admin.products.index')
            ->with($data);
    }
}
