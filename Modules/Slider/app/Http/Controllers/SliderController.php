<?php

namespace Modules\Slider\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Slider\Http\Requests\Slider\StoreRequest;
use Modules\Slider\Http\Requests\Slider\UpdateRequest;
use Modules\Slider\Models\Slider;

class SliderController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view sliders',['index','show']),
            new Middleware('can:create sliders',['create','store']),
            new Middleware('can:edit sliders',['edit','update']),
            new Middleware('can:delete sliders',['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
        $sliders = Slider::query()->select('id','title','link','status')->paginate();

        return view('slider::admin.index', compact('sliders'));
    }

    public function create(): Renderable
    {
        return view('slider::admin.create');
    }
    public function store(StoreRequest $request)
    {
        if (is_null($request->status)) {
            $request->status = false;
        }
        $slider = Slider::query()->create([
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'status' => $request->status,
        ]);
        $slider->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'اسلایدر با موفقیت ثبت شد'
        ];

        return redirect()->route('admin.sliders.index')
        ->with($data);
    }

    public function edit(Slider $slider): Renderable
    {
        return view('slider::admin.edit', compact('slider'));
    }
    public function update(UpdateRequest $request, Slider $slider)
    {
        if (is_null($request->status)) {
            $request->status = false;
        }
        $slider->update([
            'title' => $request->title,
            'parent_id' => $request->input('parent_id'),
            'featured' => $request->input('featured'),
            'link' => $request->link,
            'status' => $request->status,
        ]);
        $slider->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'اسلایدر با موفقیت به روزرسانی شد'
        ];
        return redirect()->route('admin.sliders.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        $data = [
            'status' => 'success',
            'message' => 'اسلایدر با موفقیت حذف شد'
        ];

        return redirect()->route('admin.sliders.index')
            ->with($data);
    }
}
