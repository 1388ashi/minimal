<?php

namespace Modules\Team\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Team\Models\Team;

class TeamController extends Controller
{
    public function index(): JsonResponse
    {
        $teams = Team::select('id','name','role')->orderBy('order', 'asc')->get();

        return response()->success('',compact('teams'));
    }
}