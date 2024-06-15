<?php

namespace Modules\Product\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Comment\Models\Comment;
use Modules\Product\Http\Requests\Comment\StoreRequest;

class CommentController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        $purchaseAdvisor = Comment::create($request->validated());
        
        return response()->success('نظر با موفقیت به ثبت شد.');
    }
}
