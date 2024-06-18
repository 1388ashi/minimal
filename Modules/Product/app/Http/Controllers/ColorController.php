<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Product\Http\Requests\Color\StoreRequest;
use Modules\Product\Models\Color;

class ColorController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view colors',['index','show']),
            new Middleware('can:create colors',['create','store']),
            new Middleware('can:edit colors',['edit','update']),
            new Middleware('can:delete colors',['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
        $colors = Color::query()
                    ->select('id','title','code','created_at')
                    ->latest('id')
                    ->paginate(10);
                    
        return view('product::admin.color.index', compact('colors'));
        }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colors = Color::query()
                    ->select('id','title','code','created_at')
                    ->paginate();
                    
        return view('blog::admin.category.index', compact('colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Color::query()->create([
            'title' => $request->title,
            'code' => $request->code,
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'رنگ با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.colors.index')
        ->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Color $color,StoreRequest $request): RedirectResponse
    {
        $color->update([
            'title' => $request->title,
            'code' => $request->code,
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'رنگ با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.colors.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        if ($color->posts) {
            $data = [
                'status' => 'danger',
                'message' => 'رنگ به محصولی وصل هست'
            ];
            return redirect()->route('admin.colors.index')->with($data);
        }
        $color->delete();

        $data = [
            'status' => 'success',
            'message' => 'رنگ با موفقیت حذف شد'
        ];

        return redirect()->route('admin.colors.index')
                ->with($data);
    }
}
