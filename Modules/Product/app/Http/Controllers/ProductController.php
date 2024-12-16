<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Modules\Product\Http\Requests\Product\StoreRequest;
use Modules\Product\Http\Requests\Product\UpdateRequest;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;
use Modules\Product\Models\Color;
use Modules\Specification\Models\Specification;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:view products', ['index', 'show']),
            new Middleware('can:create products', ['create', 'store']),
            new Middleware('can:edit products', ['edit', 'update']),
            new Middleware('can:delete products', ['destroy']),

        ];
    }

    public function getSpecifications(Request $request): JsonResponse
    {
        $specifications = collect([]);
        if ($request->filled('categoryIds')) {
            $product = Product::find($request->input('productId'));
            $categoryIds = $request->input('categoryIds');
            $specificationIds = DB::table('category_specification')
                ->whereIn('category_id', $categoryIds)
                ->distinct()
                ->pluck('specification_id')
                ->toArray();
            $specificationModels = Specification::query()
                ->whereIn('id', $specificationIds)
                ->select(['id', 'name'])
                ->get();


            foreach ($specificationModels as $specificationModel) {
                $specifications->push([
                    'id' => $specificationModel->id,
                    'name' => $specificationModel->name,
                    'value' => $product && $product->specifications->isNotEmpty() &&
                    $product->specifications->where('id', $specificationModel->id)->first() ?
                        $product->specifications->where('id', $specificationModel->id)->first()->pivot->value : ''
                ]);
            }
        }

        return response()->json(compact('specifications'));
    }

    public function index(): Renderable
    {
        $categories = Category::select(["id", "title"])->get();

        $title = request('title');
        $categoryId = request('category_id');
        $discount = request('discount');
        $status = request('status');

        $products = Product::query()
            ->select('id', 'title', 'price', 'discount', 'status')
            ->when($title, fn($query) => $query->where('title', 'like', "%$title%"))
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->whereHas('categories', function ($q) use ($categoryId) {
                    return $q->where('categories.id', $categoryId);
                });
            })
            ->when($discount, function ($query) use ($discount) {
                if ($discount == '1') {
                    return $query->whereNotNull('discount');
                } else {
                    return $query->whereNull('discount');
                }
            })
            ->when(isset($status), fn($query) => $query->where("status", $status))
            ->with('categories:id,title')
            ->latest('id')
            ->paginate(15);

        return view('product::admin.product.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {

        $product->load([
            'categories:id,title',
            'specifications:id,name',
            'colors:id,title,code'
        ]);

        return view('product::admin.product.show', compact('product'));

    }

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

    public function create(): Renderable
    {
        $colors = Color::select('id', 'title', 'code')->latest('id')->get();

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

        return view('product::admin.product.create', compact('allCategories', 'colors'));
    }

    public function store(StoreRequest $request)
    {
        $product = Product::create($request->validated());
        $product->uploadFiles($request);

        $specifications = $request->specifications;
        if (!is_null($specifications)) {
            foreach ($specifications as $id => $value) {
                if (!empty($value)) {
                    $product->specifications()->attach($id, ['value' => $value]);
                }
            }
        }

        $categories = $request->categories;
        foreach ($categories as $category) {
            $product->categories()->attach($category);
        }

        $colors = $request->colors;
        if (!is_null($colors)) {
            foreach ($colors as $color) {
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

        $colors = Color::select('id', 'title', 'code')->latest('id')->get();
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

        $specifications = Specification::query()
            ->with('products')
            ->whereHas('categories', function (Builder $query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id')->toArray());
            })
            ->select(['id', 'name'])
            ->get();

            return view('product::admin.product.edit', compact(
            'allCategories',
            'specifications',
            'product',
            'colors'
        ));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->uploadFiles($request);

        $product->specifications()->detach();
        $specifications = $request->specifications;

        if (filled($specifications)) {
            foreach ($specifications as $id => $value) {
                if (!empty($value)) {
                    $product->specifications()->attach($id, ['value' => $value]);
                }
            }
        }

        $categories = $request->categories;

        $product->categories()->detach();
        foreach ($categories as $category) {
            $product->categories()->attach($category);
        }

        $colors = $request->colors;
        $product->colors()->detach(); // حذف همه اتصالات قبلی
        if (!is_null($colors)) {
            foreach ($colors as $color) {
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
