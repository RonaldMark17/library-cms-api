<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return response()->json($settings);
    }

    public function show($key)
    {
        $setting = Setting::where('key', $key)->firstOrFail();
        return response()->json($setting);
    }

    public function update(Request $request, $key)
    {
        $validated = $request->validate([
            'value' => 'required',
            'type' => 'nullable|in:string,boolean,json,integer'
        ]);

        $setting = Setting::updateOrCreate(
            ['key' => $key],
            $validated
        );

        return response()->json($setting);
    }

    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array'
        ]);

        foreach ($validated['settings'] as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => gettype($value)]
            );
        }

        return response()->json(['message' => 'Settings updated successfully']);
    }
}