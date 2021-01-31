<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;
use App\Models\Role;


class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = \DB::select("select users.* from users join role_user on role_user.user_id = users.id where role_user.role_id = 2");
        
        return view('admin.drivers.index')->with('drivers', $drivers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      
        if($request->has('name'))
        {
         $validator = Validator::make($request->all(), [
            'phone_number' => 'required|unique:users',
            'name' => 'required',
            'password' => 'min:6|required_with:password2|same:password2',
            'password2' => 'min:6'
        ]);

        if ($validator->fails()) {
           $vals = json_decode($validator->errors(),1);
           $msg = "";
         
           foreach($vals as $key => $val){
               $msg .= str_replace('password2','Password Confirmation',$val[0]) ."";
           }
            \Session::flash('message','Error Creating driver: '.$msg);
            \Session::flash('class', 'alert-danger');
            return view('admin.drivers.create');
        }

        $input = $request->all();

        $input['phone_number'] = $input['phone_number'];
        $input['password'] = bcrypt($input['password']);
        $input['name'] = $request->input('name');
        // @todo: Handle Verification 
        $input['verification_code'] = '1234';

        $user = User::create($input);

        $role = '2';
        $user->roles()->attach($role);

     
           \Session::flash('message', 'Driver ' .$user->name . ' has been created');
           \Session::flash('class', 'alert-success');
        }
        
         return view('admin.drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $driver = \DB::select("select * from users where id = '{$id}' ");
        
         if($request->has('name'))
        {
            if($request->has('password') && $request->password != "")
            {
                 $validator = Validator::make($request->all(), [
                    'phone_number' => 'required',
                    'name' => 'required',
                    'password' => 'min:6|required_with:password2|same:password2',
                    'password2' => 'min:6'
                ]);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                    'phone_number' => 'required',
                    'name' => 'required'
                   
                ]);
            }

        if ($validator->fails()) {
           $vals = json_decode($validator->errors(),1);
           $msg = "";
         
           foreach($vals as $key => $val){
               $msg .= str_replace('password2','Password Confirmation',$val[0]) ."";
           }
            \Session::flash('message','Error modifying driver: '.$msg);
            \Session::flash('class', 'alert-danger');
            return view('admin.drivers.edit')->with(['driver' => $driver[0]]);
        }

        $input = $request->all();

        $input['phone_number'] = $input['phone_number'];
        $input['password'] = bcrypt($input['password']);
        $input['name'] = $request->input('name');
        // @todo: Handle Verification 
        $input['verification_code'] = '1234';

        $user = User::create($input);

        $role = '2';
        $user->roles()->attach($role);

     
           \Session::flash('message', 'Driver ' .$user->name . ' has been modified');
           \Session::flash('class', 'alert-success');
           
           return view('admin.drivers.edit')->with(['driver' => $driver[0]]);
           
        }
        
        
        // get driver info
       
        return view('admin.drivers.edit')->with(['driver' => $driver[0]]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $driver = User::find($id);
        $driver->roles()->detach();
        if ($driver->delete()) {
           \Session::flash('message', $driver->name . ' has been Deleted');
           \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error deleting the driver');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.drivers', app()->getLocale());
    }
    
    public function block($id)
    {
        $driver = User::find($id);
        $driver->is_active = 0;
        
        if ($driver->save()) {
            \Session::flash('message', $driver->name . ' has been Blocked');
            \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error blocking the driver');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.drivers', app()->getLocale());
    }
}
