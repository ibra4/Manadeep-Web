<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = json_decode(file_get_contents((storage_path('settings.json')), true));
        return view('admin.settings')->with('settings', $settings);
    }

    public function updateSettings(Request $request)
    {
        $encoded = json_encode($request->except('_token'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents(storage_path('settings.json'), $encoded);
        return redirect()->route('settings.index');
    }
}
