<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AdminAuthController extends Controller
{
    public function adminLoginPage(Request $request)
    {
        return view('admin.login');
    }
    
    public function adminLogin(Request $request)
    {
        
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $user = User::where('phone_number', $request->username)->get()->first();
        
//         return $user;
        
        
        if ($user && password_verify($request->password, $user->password)) {
//             Auth::login($user);
            return redirect()->route('admin', app()->getLocale());
        }
        $request->session()->flash('error', __('Invalid username or password'));
        return redirect()->route('admin_login', app()->getLocale());
    }
}
