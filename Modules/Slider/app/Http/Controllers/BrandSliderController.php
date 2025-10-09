<?php

namespace Modules\Slider\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Slider\Http\Requests\BrandSlider\StoreRequest;
use Modules\Slider\Http\Requests\BrandSlider\UpdateRequest;
use Modules\Slider\Models\BrandSlider;

class BrandSliderController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view sliders',['index','show']),
            new Middleware('can:create sliders',['create','store']),
            new Middleware('can:edit sliders',['edit','update']),
            new Middleware('can:delete sliders',['destroy']),
        ];
    }
    public function index(): Renderable
    {
        $sliders = BrandSlider::query()->select('id','title','link','status')->latest()->paginate();

        return view('slider::admin.brand-slider.index', compact('sliders'));
    }

    public function create(): Renderable
    {
        return view('slider::admin.brand-slider.create');
    }
    public function store(StoreRequest $request)
    {
        if (is_null($request->status)) {
            $request->status = false;
        }
        $slider = BrandSlider::query()->create([
            'title' => $request->title,
            'link' => $request->link,
            'type' => $request->type,
            'status' => $request->status,
        ]);
        $slider->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'اسلایدر با موفقیت ثبت شد'
        ];

        return redirect()->route('admin.brand-sliders.index')
        ->with($data);
    }

    public function edit($id): Renderable
    {
        $slider = BrandSlider::find($id);

        return view('slider::admin.brand-slider.edit', compact('slider'));
    }
    public function update(UpdateRequest $request, BrandSlider $slider)
    {
        if (is_null($request->status)) {
            $request->status = false;
        }
        $slider->update([
            'title' => $request->title,
            'type' => $request->type,
            'link' => $request->link,
            'status' => $request->status,
        ]);
        $slider->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'اسلایدر با موفقیت به روزرسانی شد'
        ];
        return redirect()->route('admin.brand-sliders.index')
        ->with($data);
    }

    public function destroy($id)
    {
        $slider = BrandSlider::find($id);
        $slider->delete();

        $data = [
            'status' => 'success',
            'message' => 'اسلایدر با موفقیت حذف شد'
        ];

        return redirect()->route('admin.brand-sliders.index')
            ->with($data);
    }
}
