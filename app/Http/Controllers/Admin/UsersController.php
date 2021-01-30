<?php

namespace App\Http\Controllers\Admin;
// namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Rate;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        $All_user =array();
        
        foreach ($users as $user){
            if($user->roles()->get()->pluck('name')[0] == "user"){
                $All_user []= $user;
            }
        }
        echo "<pre>";
        print_r($All_user);
        die();
        return view('admin.users.index')->with('users', $All_user);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }
        if ($request->has('password') && $request->password != null) {
            $user->password = Hash::make($request->password);
        }
        $user->name = $request->name;
        if ($request->has('email') && $request->email != null) {
            $user->email = $request->email;
        }
        if ($user->save()) {
            $request->session()->flash('success', $user->name . ' Has been Updated');
        } else {
            $request->session()->flash('error', 'Error updating the user');
        }
        
        return redirect()->route('admin.users.index', app()->getLocale());
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
//         $user = User::where('id', $id)->first();
        $user->roles()->detach();
        if ($user->delete()) {
            $request->session()->flash('success', $user->name . ' Has been Deleted');
        } else {
            $request->session()->flash('error', 'Error deleting the user');
        }
        return redirect()->route('admin.users', app()->getLocale());
    }
    
    public function rates(Request $request, User $user)
    {
        $rates = Rate::all();
        return view('admin.users.rates')->with([
            'user' => $user,
            'rates' => $rates
        ]);
    }
    
    public function orders($request)
    {
       
        $orders = Order::all();
//         die($Get);

        return view('admin.users.orders')->with([
           // 'user' => $user,
            'orders' => $orders
        ]);
    }
    
//     public function AuthRouteAPI(Request $request)
//     {
//         return $request->user();
//     }
}
