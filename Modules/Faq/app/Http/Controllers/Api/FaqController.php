<?php

namespace Modules\Faq\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Faq\Models\Ask;

class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        $asks = Ask::select('id','question','reply','status')->where('status',1)->get();

        return response()->success('',compact('asks'));
    }
}