<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;

class SettingsController extends BaseController
{
    public function get(Request $request)
    {
        $settings = json_decode(file_get_contents((storage_path('settings.json')), true));
        return $this->sendResponse($settings, 'success');
    }

    public function update(Request $request)
    {
        $encoded = json_encode($request->except('_token'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $updated = file_put_contents(storage_path('settings.json'), $encoded);
        if ($updated) {
            return $this->sendResponse('updated successfully', 'success');
        } else {
            return $this->sendError('error updating app settings', 'error');
        }
    }
}
