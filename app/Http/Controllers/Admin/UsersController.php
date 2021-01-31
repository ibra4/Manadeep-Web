<?php
namespace App\Http\Controllers\Admin;

// namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Rate;
use Illuminate\Support\Facades\Hash;
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
        $All_user = array();

        foreach ($users as $user) {

            $All_user[] = $user;
        }

        return view('admin.users.index')->with('users', $All_user);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        $user_roles = \DB::select("select * from role_user where user_id = '{$id}' ");

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
            'user_roles' => $user_roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $user = User::find($id);
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

        return redirect()->route('admin.users', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->roles()->detach();
        if ($user->delete()) {
           \Session::flash('message', $user->name . ' Has been Deleted');
           \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error deleting the user');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.users', app()->getLocale());
    }

    public function rates($id)
    {
        $rates = \DB::select("select * from orders join rates on orders.rate_id = rates.id where orders.user_id = '{$id}' ");
        $user = User::find($id);

        return view('admin.users.rates')->with([
            'user' => $user,
            'rates' => $rates
        ]);
    }

    public function orders($id)
    {
        $user = User::find($id);
        $orders = \DB::select("select * , ( select name as driver_name from users where id = orders.driver_id ) as driver_name from orders where orders.user_id = '{$id}' ");

        return view('admin.users.orders')->with([
            'user' => $user,
            'orders' => $orders
        ]);
    }

    // public function AuthRouteAPI(Request $request)
    // {
    // return $request->user();
    // }
}
