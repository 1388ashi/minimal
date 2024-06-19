<?php

namespace Modules\JobOffer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\JobOffer\Http\Requests\Resumes\UpdateRequest;
use Modules\JobOffer\Models\Resumes;

class ResumesController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view resumes',['index','show']),
            new Middleware('can:delete resumes',['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resumes = Resumes::filters(request()->query())
        ->select('id','name','mobile','job_id','created_at','status')
        ->with('job:id,title')
        ->latest('id')
        ->paginate(15);
        $filterInputs = Resumes::getFilterInputs();

        return view('joboffer::admin.resumes.index', compact('resumes','filterInputs')); 
    }  
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $resume = Resumes::with('job:id,title')->findOrFail($id);
        dd($resume);
        return view('joboffer::admin.resumes.show', compact('resume')); 
    }
    
    public function update(Resumes $resume,Request $request): RedirectResponse
    {
        $resume->update([
            'status' => $request->status,
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'رزومه با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.resumes.index')
        ->with($data);
    }
}
