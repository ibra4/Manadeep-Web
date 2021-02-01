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
        // commissions
        $commission = \DB::select("select * from commissions where commission_name = 'Driver_commission' order by effective_from desc limit 1");

        // get drives with custom commissions first
        $cusom_comm_drivers = \DB::select("select * from users where driver_custom_commission is not null");
        $total_orders = ['drivers' => 0, 'manadeep' => 0];
        $exclude_drivers = [];
        if(count($cusom_comm_drivers) > 0)
        {
            for($i = 0 ; $i < count($cusom_comm_drivers); $i++)
            {
                $custom_per_driver = \DB::select("select sum(price) as summ from orders where driver_id =  '{$cusom_comm_drivers[$i]->id}'  and status='finished' ");
                $exclude_drivers[] = $cusom_comm_drivers[$i]->id;

                $total_orders['drivers'] += ($cusom_comm_drivers[$i]->driver_custom_commission ) * $custom_per_driver[0]->summ;
                $total_orders['manadeep'] += ((1 - $cusom_comm_drivers[$i]->driver_custom_commission)  ) * $custom_per_driver[0]->summ;
            }

        }


        $exc = "";
        if(count($exclude_drivers)>0)
        {
            $exc = " and driver_id not in ( ".implode(",", $exclude_drivers)." ) ";
        }
        $all_drivers_comm = \DB::select("select sum(price) as summ from orders where driver_id is not null and status='finished' ");
        $all_commss = \DB::select("select * from commissions where commission_name = 'Driver_commission'");

        for($i = 0; $i < count($all_commss); $i++)
        {
            if($all_commss[$i]->effective_to != "")
            {
                $period = \DB::select("select sum(price) as summ from orders where created_at between '{$all_commss[$i]->effective_from}' and '{$all_commss[$i]->effective_to}'  and status='finished' {$exc}");
               // echo "select sum(price) as summ from orders where created_at between '{$all_commss[$i]->effective_from}' and '{$all_commss[$i]->effective_to}' <br>";
            }
            else
            {
                $period = \DB::select("select sum(price) as summ from orders where created_at >= '{$all_commss[$i]->effective_from}'  and status='finished' {$exc}");
               // echo "select sum(price) as summ from orders where created_at >= '{$all_commss[$i]->effective_from}' <br> ";
            }

            $total_orders['drivers'] += $all_commss[$i]->commission_value * $period[0]->summ;
            $total_orders['manadeep'] += (1 - $all_commss[$i]->commission_value) * $period[0]->summ;

        }

        $today = date("Y-m-d 00:00:00");
        $drivers = \DB::select("select users.*, (select sum(price) from orders where driver_id = users.id and status='finished' and created_at >= '{$today}' ) as todays_income from users join role_user on role_user.user_id = users.id where role_user.role_id = 2");

        return view('admin.drivers.index')->with('drivers', $drivers)
        ->with('commission' , $commission[0])
        ->with('drivers_com' ,$all_drivers_comm[0])
        ->with('total_profits', $total_orders);
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
    public function updatepercentage(Request $request)
    {
       if($request->has('profit_percentage') && $request->profit_percentage != "")
       {
           $dt = date("Y-m-d H:i:s.u");
           $profit_percentage = $request->profit_percentage / 100;
           $latest = \DB::select("select * from commissions where commission_name = 'Driver_commission' order by effective_from desc limit 1");

           // update latest open setting

           \DB::update("update commissions set effective_to = '{$dt}' where id = '{$latest[0]->id}' ");

           \DB::insert("insert into commissions ( commission_name, commission_value, created_at, updated_at, effective_from ) values ( 'Driver_commission' , '{$profit_percentage}' ,
           '{$dt}' , '{$dt}' , '{$dt}' ) ");

           \Session::flash('message', 'New profit percentage is added, effective as of '.date("d/m/Y H:i:s",strtotime($dt)));
           \Session::flash('class', 'alert-success');

           return redirect()->route('admin.drivers', app()->getLocale());
       }

       return redirect()->route('admin.drivers', app()->getLocale());

    }

    public function orders($id)
    {
        $driver = \DB::select("select * from users where id = '{$id}' ");
        // Driver's Orders
        $orders = \DB::select("select * from orders where driver_id = '{$id}' ");
        return view('admin.drivers.orders')->with('orders' , $orders)->with('driver' , $driver[0]);
    }


    public function updatecomm(Request $request)
    {
       if($request->has('driver_id') && $request->driver_id != "")
       {

           if($request->has('driver_custom_commission') && $request->driver_custom_commission != "")
           {
               $perc = $request->driver_custom_commission / 100;
               \DB::update("update users set driver_custom_commission = '{$perc}' where id = '{$request->driver_id}' ");
           }
           else
           {
               \DB::update("update users set driver_custom_commission = null where id = '{$request->driver_id}' ");
           }

           \Session::flash('message', 'Custom Profit percentage is updated');
           \Session::flash('class', 'alert-success');

           return redirect()->route('admin.drivers', app()->getLocale());
       }

       return redirect()->route('admin.drivers', app()->getLocale());

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

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->id = $id;
        $user->phone_number = $input['phone_number'];
        if($request->input('password') != "")
        {
            $user->password = bcrypt($request->input('password'));
        }
        $user->email = $request->input('email');
        $user->save();

            $driver = \DB::select("select * from users where id = '{$id}' ");
           \Session::flash('message', 'Driver ' .$user->name . ' has been modified');
           \Session::flash('class', 'alert-success');

           return view('admin.drivers.edit')->with(['driver' => $driver[0]]);

        }

        $driver = \DB::select("select * from users where id = '{$id}' ");
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
