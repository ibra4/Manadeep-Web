<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class Notifications extends Controller
{
    public function show()
    {
//         $notification = Notification::where('user_id',auth('api')->user()->id)->get();
        $notification = Notification::where('user_id',auth('api')->user()->id)
        ->where('status','active')
        ->get();
        return response()->json([
            "data" => $notification,
            "message" => "success"
        ], 201);
    }
    public function seen($id)
    {
        $notification = Notification::find($id);
        $notification ->seen = '1';
        $notification->save();
        
        return response()->json([
            "data" => $notification,
            "message" => "success"
        ], 201);
    }
    
    public function notificationNumber()
    {
        $notification = Notification::where('user_id',auth('api')->user()->id)
        ->where('user_id',auth('api')->user()->id)
        ->where('status','active')
        ->count();
        return response()->json([
            "data" => $notification,
            "message" => "success"
        ], 201);
        
        return response()->json([
            "data" => $notification,
            "message" => "success"
        ], 201);
    }
}
