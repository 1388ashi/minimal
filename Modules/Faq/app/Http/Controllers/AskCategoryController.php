<?php

namespace Modules\Faq\Http\Controllers;

use App\Http\Controllers\Controller;
// use Illuminate\Contracts\Support\Renderable;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Routing\Controllers\Middleware;
// use Illuminate\Http\Request;
// use Illuminate\Routing\Controllers\HasMiddleware;
// use Modules\Faq\Http\Requests\Ask\StoreRequest;
// use Modules\Faq\Models\AskCategory;

// class AskCategoryController extends Controller implements HasMiddleware
// {
//     public static function middleware(){
//         return [
//             new Middleware('can:view faq',['index','show']),
//             new Middleware('can:create faq',['create','store']),
//             new Middleware('can:edit faq',['edit','update']),
//             new Middleware('can:delete faq',['destroy']),

//         ];
//     }
//     /**
//      * Display a listing of the resource.
//      */
//     public function index(): Renderable
//     {
//         $ask_categories = AskCategory::query()
//                     ->select('id','title','status','created_at')
//                     ->latest('id')
//                     ->paginate(15);
                    
//         return view('faq::admin.category.index', compact('ask_categories'));
//     }
    
//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         $ask_categories = AskCategory::query()
//                     ->select('id','title','type','status','created_at')
//                     ->paginate();
                    
//         return view('faq::admin.category.index', compact('ask_categories'));
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(StoreRequest $request): RedirectResponse
//     {
//         AskCategory::query()->create([
//             'title' => $request->title,
//             'status' => filled($request->status) ?: 0
//         ]);
        
//         $data = [
//             'status' => 'success',
//             'message' => 'دسته بندی با موفقیت ثبت شد'
//         ];
        
//         return redirect()->route('admin.ask-categories.index')
//         ->with($data);
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(AskCategory $ask_category,StoreRequest $request): RedirectResponse
//     {
//         $ask_category->update([
//             'title' => $request->title,
//             'status' => filled($request->status) ?: 0
//         ]);
        
//         $data = [
//             'status' => 'success',
//             'message' => 'دسته بندی با موفقیت به روزرسانی شد'
//         ];
        
//         return redirect()->route('admin.ask-categories.index')
//         ->with($data);
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(AskCategory $ask_category)
//     {
//         // if ($ask_category->asks) {
//         //     $data = [
//         //         'status' => 'danger',
//         //         'message' => 'دسته بندی به سوالی وصل هست'
//         //     ];
//         //     return redirect()->route('admin.ask-categories.index')->with($data);
//         // }
//         $ask_category->delete();

//         $data = [
//             'status' => 'success',
//             'message' => 'دسته بندی با موفقیت حذف شد'
//         ];

//         return redirect()->route('admin.ask-categories.index')
//                 ->with($data);
//     }
// }
