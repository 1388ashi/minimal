<?php

namespace Modules\Faq\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Faq\Http\Requests\Ask\StoreRequest;
use Modules\Faq\Models\Ask;

class AskController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view faq',['index','show']),
            new Middleware('can:create faq',['create','store']),
            new Middleware('can:edit faq',['edit','update']),
            new Middleware('can:delete faq',['destroy']),
        ];
    }
    public function index(): Renderable
    {
        $asks = Ask::query()
                    ->select('id','question','reply','status','created_at')
                    ->latest('id')
                    ->paginate(10);
                    
        return view('faq::admin.asks.index', compact('asks'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faq::admin.asks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Ask::query()->create([
            'question' => $request->question,
            'reply' => $request->reply,
            'status' => filled($request->status) ?: 0
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'سوال با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.asks.index')
        ->with($data);
    }
    public function edit(Ask $ask)
    {
        return view('faq::admin.asks.edit',compact('ask'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Ask $ask,StoreRequest $request): RedirectResponse
    {
        $ask->update([
            'question' => $request->question,
            'reply' => $request->reply,
            'status' => filled($request->status) ?: 0
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'سوال با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.asks.index')
        ->with($data);
    }

    /**
     * Show the specified resource.
     */
    public function show(Ask $ask)
    {
        return view('faq::admin.asks.show',compact('ask'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ask $ask)
    {
        $ask->delete();

        $data = [
            'status' => 'success',
            'message' => 'سوال با موفقیت حذف شد'
        ];

        return redirect()->route('admin.asks.index')
                ->with($data);
    }
}
