<?php

namespace Modules\Team\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Modules\Team\Models\Team;
use Modules\Team\Http\Requests\StoreRequest;

class TeamController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('can:view teams',['index','show']),
            new Middleware('can:create teams',['create','store']),
            new Middleware('can:edit teams',['edit','update']),
            new Middleware('can:delete teams',['destroy']),

        ];
    }
    public function sort(Request $request)
    {
        dd($request->teams);
        Team::setNewOrder($request->teams);

        return redirect()->route('admin.teams.index')
        ->with('success', 'ایتم ها با موفقیت مرتب شد.');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::select('id','name','role','order')->orderBy('order', 'asc')->get();
        
        return view('team::admin.index',compact('teams'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::select('id','name','role')->get();
        
        return view('team::admin.index',compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $team = Team::query()->create([
            'name' => $request->name,
            'role' => $request->role,
        ]);
        $team->uploadFiles($request);
        $data = [
            'status' => 'success',
            'message' => 'عضو با موفقیت ثبت شد'
        ];
        
        return redirect()->route('admin.teams.index')
        ->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Team $team): RedirectResponse
    {
        $team->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);
        $team->uploadFiles($request);
        
        $data = [
            'status' => 'success',
            'message' => 'عضو با موفقیت به روزرسانی شد'
        ];
        
        return redirect()->route('admin.teams.index')
        ->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        $data = [
            'status' => 'success',
            'message' => 'عضو با موفقیت حذف شد'
        ];

        return redirect()->route('admin.teams.index')
            ->with($data);
    }
}
