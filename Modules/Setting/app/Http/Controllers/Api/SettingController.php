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

        $groupedSettings = [];

        foreach ($settings as $setting) {
            if ($setting->type == 'image' && isset($setting->file['url'])) {
                $setting->value = $setting->file['url'];
            }

            $group = $setting->group ?? 'default';
            $name = $setting->name;

            if (!isset($groupedSettings[$group])) {
                $groupedSettings[$group] = [];
            }

            $groupedSettings[$group][$name] = $setting;
        }

        return response()->json([
            'settings' => $groupedSettings,
        ]);
    }
}
