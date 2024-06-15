<?php

namespace Modules\Setting\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Setting\Models\Setting;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Setting::all();

        return response()->success('',compact('settings'));
    }
}
