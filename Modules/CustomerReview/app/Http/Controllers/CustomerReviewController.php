<?php

namespace Modules\CustomerReview\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\CustomerReview\Http\Requests\StoreRequest;
use Modules\CustomerReview\Http\Requests\UpdateRequest;
use Modules\CustomerReview\Models\CustomerReview;

class CustomerReviewController extends Controller implements HasMiddleware
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
        $customerReviews = CustomerReview::select('id','name','city','description')->paginate();

        return view('customerreview::admin.index',compact('customerReviews'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customerReviews = CustomerReview::select('id','name','city','description')->paginate();
    
        return view('customerreview::admin.index',compact('customerReviews'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $customerReview = CustomerReview::query()->create([
            'name' => $request->name,
            'city' => $request->city,
            'description' => $request->description,
        ]);
        $customerReview->uploadFiles($request);
        $data = [
            'status' => 'success',
            'message' => 'نظر با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.customer-reviews.index')
        ->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request,CustomerReview $customerReview): RedirectResponse
    {
        $customerReview->update([
            'name' => $request->name,
            'city' => $request->city,
            'description' => $request->description,
        ]);
        $customerReview->uploadFiles($request);
        
        $data = [
            'status' => 'success',
            'message' => 'نظر با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.customer-reviews.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerReview $customerReview)
    {
        $customerReview->delete();

        $data = [
            'status' => 'success',
            'message' => 'نظر با موفقیت حذف شد'
        ];

        return redirect()->route('admin.customer-reviews.index')
            ->with($data);
    }
}