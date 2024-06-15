<?php

namespace Modules\JobOffer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\JobOffer\Http\Requests\Job\StoreRequest;
use Modules\JobOffer\Http\Requests\Resumes\UpdateRequest;
use Modules\JobOffer\Models\JobOffer;

class JobOfferController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view jobs',['index','show']),
            new Middleware('can:create jobs',['create','store']),
            new Middleware('can:edit jobs',['edit','update']),
            new Middleware('can:delete jobs',['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobOffer::select('id','title','times','type','status')->paginate();
        
        return view('joboffer::admin.jobs.index',compact('jobs'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if (is_null($request->status)) {
            $request->status = false;
        }
        $job = JobOffer::query()->create([
            'title' => $request->title,
            'times' => $request->times,
            'type' => $request->type,
            'status' => $request->status,
        ]);
        $data = [
            'status' => 'success',
            'message' => 'شغل با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.jobs.index')
        ->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request,JobOffer $job): RedirectResponse
    {
        $job->update([
            'title' => $request->title,
            'times' => $request->times,
            'type' => $request->type,
            'status' => $request->status,
        ]);
        $data = [
            'status' => 'success',
            'message' => 'شغل با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.jobs.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $job)
    {
        $job->delete();

        $data = [
            'status' => 'success',
            'message' => 'شغل با موفقیت حذف شد'
        ];

        return redirect()->route('admin.jobs.index')
            ->with($data);
    }
}
