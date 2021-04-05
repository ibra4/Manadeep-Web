<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Contact;
use App\Models\AdminMessage;
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

        $user = User::where('phone', $request->username)->get()->first();

//         return $user;

        echo $request->password . "<br>";
        echo $user->password . "<br>";

        $hasher = app('hash');

        if ($hasher->check($request->password, $user->password)) {
            // Success

            Auth::login($user);
            return redirect()->route('admin', app()->getLocale());
        }
        $request->session()->flash('error', __('Invalid username or password'));
        return redirect()->route('admin_login', app()->getLocale());
    }
    
    public function ShowMessages()
    {
        $AdminMessage=AdminMessage::all();
        $AllMessages= array();
        
        
        foreach ($AdminMessage as $key){
            $user = User::find($key->user_id);
            $key->user_id=$user->name;
            $AllMessages[] =$key;
        }
        
        return view('admin.message')->with('messages', $AllMessages);
    }
    
    public function ShowContact()
    {
        $Contact=Contact::all();
        return view('admin.contact')->with('Contact', $Contact);
    }
}
