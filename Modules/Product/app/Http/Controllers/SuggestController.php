<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Product\Http\Requests\Suggest\StoreRequest;
use Modules\Product\Models\Product;
use Modules\Product\Models\Suggestion;

class SuggestController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::select('id','product_id')->with('product:id,title')->paginate();
        $products = Product::select('id','title')->get();
        
        return view('product::admin.suggestions.index',compact('suggestions','products'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Suggestion::query()->create([
            'product_id' => $request->product_id
        ]);
        $data = [
            'status' => 'success',
            'message' => 'محصول با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.suggestions.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suggestion $suggestion)
    {
        $suggestion->delete();
        $data = [
            'status' => 'success',
            'message' => 'محصول با موفقیت حذف شد'
        ];

        return redirect()->route('admin.suggestions.index')
            ->with($data);
    }
}
