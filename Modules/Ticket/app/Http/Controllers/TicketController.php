<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Ticket\Models\Ticket;

class TicketController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view comments',['index','show']),
            new Middleware('can:edit comments',['edit','update']),
            new Middleware('can:delete comments',['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::filters(request()->query())
        ->select('id','name','mobile','email','description','status')
        ->latest('id')
        ->paginate(15);
        $filterInputs = Ticket::getFilterInputs();

        return view('ticket::admin.index', compact('tickets','filterInputs'));
    }
    public function update(Ticket $ticket,Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'status' => ['required','in:pending,accepted'],
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        $data = [
            'status' => 'success',
            'message' => 'پیام با موفقیت به روزرسانی شد'
        ];

        return redirect()->route('admin.tickets.index')
        ->with($data);
    }
}
