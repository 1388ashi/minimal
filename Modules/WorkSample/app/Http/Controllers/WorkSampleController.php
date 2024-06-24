<?php

namespace Modules\WorkSample\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\WorkSample\Http\Requests\StoreRequest;
use Modules\WorkSample\Http\Requests\UpdateRequest;
use Modules\WorkSample\Models\WorkSample;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WorkSampleController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view workSample',['index','show']),
            new Middleware('can:create workSample',['create','store']),
            new Middleware('can:edit workSample',['edit','update']),
            new Middleware('can:delete workSample',['destroy']),

        ];
    }
    public function index()
    {
        $workSamples = WorkSample::select('id','title')->paginate();

        return view('worksample::admin.index',compact('workSamples'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
         $workSample =  WorkSample::query()->create([
            'title' => $request->title,
        ]);
        $workSample->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'نمونه کار با موفقیت ثبت شد'
        ];

        return redirect()->route('admin.work-samples.index')
        ->with($data);
    }

    /**
     * Show the specified resource.
     */
    public function show(WorkSample $workSample)
    {
        return view('worksample::admin.show',compact('workSample'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request,WorkSample $workSample): RedirectResponse
    {
        $workSample->update([
            'title' => $request->title,
        ]);
        $workSample->uploadFiles($request);

        $data = [
            'status' => 'success',
            'message' => 'نمونه کار با موفقیت به روزرسانی شد'
        ];

        return redirect()->route('admin.work-samples.index')
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

        return redirect()->route('admin.work-samples.index')
            ->with($data);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkSample $workSample)
    {
        $workSample->delete();

        $data = [
            'status' => 'success',
            'message' => 'نمونه کار با موفقیت حذف شد'
        ];

        return redirect()->route('admin.work-samples.index')
            ->with($data);
    }
}
