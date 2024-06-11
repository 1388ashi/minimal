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
        ->select('id','name','mobile','email','description')
        ->latest('id')
        ->paginate(15);
        $filterInputs = Ticket::getFilterInputs();

        return view('ticket::admin.index', compact('tickets','filterInputs')); 
    }  
}
