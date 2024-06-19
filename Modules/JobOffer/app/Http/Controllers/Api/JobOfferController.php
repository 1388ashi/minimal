<?php

namespace Modules\JobOffer\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\JobOffer\Http\Requests\Resumes\StoreRequest;
use Modules\JobOffer\Models\JobOffer;
use Modules\JobOffer\Models\Resumes;

class JobOfferController extends Controller
{
    public function index(): JsonResponse
    {
        $jobOffers = JobOffer::select('id','title','times','type','status','created_at')->get();

        return response()->success('',compact('jobOffers'));
    }
    public function store(StoreRequest $request): JsonResponse
    {
        $resumes = Resumes::create($request->validated());
        dd($request->all());
        $resumes->uploadFiles($request);

        return response()->success('رزومه با موفقیت به ثبت شد.');
    }
}
