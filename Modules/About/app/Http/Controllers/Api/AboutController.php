<?php

namespace Modules\About\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\About\Models\AboutUs;

class AboutController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::all();

        return response()->success('',compact('aboutUs'));
    }
}
