<?php

namespace Modules\CustomerReviews\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\customerRaview\Models\customerRaview;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Response;

class CustomerReviewsController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view customerRaviews',['index','show']),
            new Middleware('can:create customerRaviews',['create','store']),
            new Middleware('can:edit customerRaviews',['edit','update']),
            new Middleware('can:delete customerRaviews',['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerRaviews = customerRaview::select('id','name','city','description');

        return view('customerreviews::admion.index',compact('customerRaviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customerreviews::create');
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
        return view('customerreviews::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('customerreviews::edit');
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
