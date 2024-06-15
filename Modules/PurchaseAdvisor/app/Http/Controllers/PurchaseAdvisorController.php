<?php

namespace Modules\PurchaseAdvisor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\PurchaseAdvisor\Models\PurchaseAdvisor;

class PurchaseAdvisorController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view purchase_advisors',['index']),
            new Middleware('can:edit purchase_advisors',['update']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseAdvisors = PurchaseAdvisor::filters(request()->query())
        ->select('id','name','mobile','status','product_id')
        ->with('product:id,title')
        ->latest('id')
        ->paginate(15);
        $filterInputs = PurchaseAdvisor::getFilterInputs();

        return view('purchaseadvisor::admin.index', compact('purchaseAdvisors','filterInputs')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,PurchaseAdvisor $purchaseAdvisor): RedirectResponse
    {
        $purchaseAdvisor->update([
            'status' => $request->status,
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'مشاوره با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.purchase-advisors.index')
        ->with($data);
    }
}
