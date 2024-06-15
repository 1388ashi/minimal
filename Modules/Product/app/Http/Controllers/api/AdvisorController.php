<?php

namespace Modules\Product\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Http\Requests\Advistor\StoreRequest;
use Modules\PurchaseAdvisor\Models\PurchaseAdvisor;

class AdvisorController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        $purchaseAdvisor = PurchaseAdvisor::create($request->validated());

        return response()->success('مشاوره خرید با موفقیت به ثبت شد.');
    }
}
