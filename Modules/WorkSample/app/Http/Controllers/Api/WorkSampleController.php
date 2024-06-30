<?php

namespace Modules\WorkSample\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\WorkSample\Models\WorkSample;

class WorkSampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workSamples = WorkSample::select('id','title')->latest('id')->get();

        return response()->success('',compact('workSamples'));
    }
}
