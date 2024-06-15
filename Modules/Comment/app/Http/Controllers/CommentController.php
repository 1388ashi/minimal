<?php

namespace Modules\Comment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Comment\Http\Requests\UpdateRequest;
use Modules\Comment\Models\Comment;

class CommentController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view comments',['index','show']),
            new Middleware('can:edit comments',['update']),
            new Middleware('can:delete comments',['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::filters(request()->query())
        ->select('id','name','mobile','product_id','created_at','status')
        ->with('product:id,title')
        ->latest('id')
        ->paginate(15);
        $filterInputs = Comment::getFilterInputs();

        return view('comment::admin.comments.index', compact('comments','filterInputs')); 
    }  
    
    public function update(Comment $comment,UpdateRequest $request): RedirectResponse
    {
        $comment->update([
            'status' => $request->status,
            'description' => $request->description,
        ]);
        
        $data = [
            'status' => 'success',
            'message' => 'نظر با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.comments.index')
        ->with($data);
    }
    /**
     * Show the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment->load(['product:id,title']);

        return view('comment::admin.comments.show', compact('comment')); 
    }

    /**
     * Remove the specified resource from storage.
     */
}
