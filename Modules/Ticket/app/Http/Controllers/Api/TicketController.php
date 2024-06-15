<?php

namespace Modules\Ticket\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ticket\Http\Requests\StoreRequest;
use Modules\Ticket\Models\Ticket;

class TicketController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        $ticket = Ticket::create($request->validated());
        
        return response()->success('پیام با موفقیت ارسال شد.');
    }
}