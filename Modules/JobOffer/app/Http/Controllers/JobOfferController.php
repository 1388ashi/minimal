<?php

namespace Modules\JobOffer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
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
        $jobOffers = JobOffer::select('id','title','role')->paginate();
        
        return view('joboffer::admin.jobs.index',compact('jobOffers'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('joboffer::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('joboffer::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('joboffer::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
