<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Driver;
class OrdersController extends BaseController
{

    public function __construct()
    {
        $this->middleware('can:add-order')->only('add');
        $this->middleware('can:take-order')->only('status');
        $this->middleware('can:manage-website')->only(['getAll']);
    }

    public function getAll(Request $request)
    {
        $orders = Order::all();
        return $this->sendResponse($orders, 'success');
    }

    public function get(Request $request)
    {
        $user = auth('api')->user();

        $user_id_string = "user_id";

        if ($user->hasRole('driver')) {
            $user_id_string = "driver_id";
        }
        $orders = Order::select('id', 'user_id', 'driver_id', 'created_at', 'fromName', 'toName', 'status', 'comments')
            ->where($user_id_string, $user->id)->with([
                'user' => function ($q) {
                    $q->select('id', 'name');
                },
                'driver' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->get();
        return $this->sendResponse($orders, 'success');
    }

    public function getByOrderPath(Request $request, $orderPath)
    {
        $order = Order::select('id', 'user_id', 'driver_id', 'created_at', 'fromName', 'toName', 'status', 'comments')
            ->where('orderPath', 'orders/' . $orderPath)->with([
                'user' => function ($q) {
                    $q->select('id', 'name');
                },
                'driver' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->get()->first();
        return $this->sendResponse($order, 'success');
    }

    public function getActiveOrder(Request $request)
    {

        $user_id_string = 'user_id';
        $where_in = ['in_progress', 'from_reached', 'driving'];
        $columns = ['id', 'user_id', 'driver_id', 'created_at', 'fromName', 'toName', 'status', 'comments', 'orderPath'];
        /** @var \App\Models\User $user */
        $user = auth('api')->user();

        if ($user->hasRole('driver')) {
            $user_id_string = 'driver_id';
            $where_in = ['from_reached', 'driving'];
            $columns = ['id', 'user_id', 'driver_id', 'created_at', 'fromName', 'toName', 'status', 'comments', 'orderPath', 'from', 'to', 'fromName', 'toName'];
        }

        $orders = Order::select($columns)
            ->where($user_id_string, $user->id)
            ->whereIn('status', $where_in)->with([
                'user' => function ($q) {
                    $q->select('id', 'name');
                },
                'driver' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->get()->first();
        return $this->sendResponse($orders, 'success');
    }

    public function getSingle(Request $request, Order $order, $id)
    {
        $user = auth('api')->user();

        $order = $order->newQuery()->with([
            'user' => function ($q) {
                $q->select('id', 'name', 'phone_number');
            },
            'driver' => function ($q) {
                $q->select('id', 'name');
            },
            'rate'
        ])->where('id', $id);

        if (!$user->hasRole('admin')) {
            if ($user->hasRole('user')) {
                $order->where('user_id', $user->id);
            } else if ($user->hasRole('driver')) {
                $order->where('driver_id', $user->id);
            }
        }

        return $this->sendResponse($order->get()->first(), 'success');
    }

    public function add(Request $request)
    {
        $request->validate([
            'fromLat' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'fromLng' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'fromName' => 'required',
            'toLat' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'toLng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'toName' => 'required',
            'cost' => 'required|numeric',
            'payer' => 'required',
            'comments' => 'required',
            'package' => 'required',
            'orderPath' => 'required',
            'recieverName' => 'required',
            'recieverPhone' => 'required',
            'estimate_time'=> 'required',
        ]);

        $order = new Order();

        $order->from = $request->input('fromLat') . ',' . $request->input('fromLng');
        $order->to = $request->input('toLat') . ',' . $request->input('toLng');
        $order->fromName = $request->input('fromName');
        $order->toName = $request->input('toName');
        $order->cost = $request->input('cost');
        $order->orderPath = $request->input('orderPath');
        $order->driver_id = null;
        $order->rate_id = null;
        $order->city = $request->has('city') ? $request->input('city') : null;
        $order->user_id = auth('api')->user()->id;
        $order->status = 'in_progress';
        $order->payer = $request->input('payer');
        $order->package = $request->input('package');
        $order->comments = $request->input('comments');
        $order->recieverName = $request->input('recieverName');
        $order->recieverPhone = $request->input('recieverPhone'); 
        $order->price = $request->has('price') ? $request->input('price') : 0;
        $order->estimate_time= $request->input('estimate_time');
        $order->save();

        $Notification = new Notification();
        $Notification->user_id = auth('api')->user()->id;
        $Notification->Order_id = $order->id;
        $Notification->note_en = "Your order added successfully, Please wait to a driver accept it";
        $Notification->note_ar = "ØªÙ… Ø¥Ø¶Ø§Ù�Ø© Ø·Ù„Ø¨Ùƒ,Ø§Ù„Ø±Ø¬Ø§Ø¡ Ø§Ù†ØªØ¶Ø§Ø± Ù…ÙˆØ§Ù�Ù‚Ø© Ø§Ù„Ø³Ø§Ø¦Ù‚";
        $Notification->prcoss = "NewOrder";
        $Notification->seen = '0';
        $Notification->save();
        
        
        
        return $this->sendResponse($order, 'created successfully');
    }

    public function status(Request $request, $id)
    {
        $request->validate([
            'status' => "required|in:canceled,in_propgress,driving,from_reached,finished,manadeep"
        ]);
        $order = Order::find($id);
        $order->driver_id = auth('api')->user()->id;
        $order->status = $request->input('status');
        $order->save();
        
        if($request->input('status')== "driving"){
            
            $update  = Notification::where('order_id','=',$order->id)
            ->update(['status' => 'inactive']);
            
            $Notification = new Notification();
            $Notification->user_id = $order->user_id;
            $Notification->Order_id = $order->id;
            $Notification->note_en = "The driver accept your order";
            $Notification->note_ar = "السائق وافق على طلبك";
            $Notification->prcoss = "NewOrder";
            $Notification->seen = '0';
            $Notification->save();
        }
        
        if($request->input('status')== "from_reached"){
            
            $update  = Notification::where('order_id','=',$order->id)
            ->update(['status' => 'inactive']);
            
            $Notification = new Notification();
            $Notification->user_id = $order->user_id;
            $Notification->Order_id = $order->id;
            $Notification->note_en = "The driver has arrived";
            $Notification->note_ar = "السائق وصل";
            $Notification->prcoss = "NewOrder";
            $Notification->seen = '0';
            $Notification->save();
        }
        
        if($request->input('status')== "finished"){
            
            $update  = Notification::where('order_id','=',$order->id)
            ->update(['status' => 'inactive']);
            
            $Notification = new Notification();
            $Notification->user_id = $order->user_id;
            $Notification->Order_id = $order->id;
            $Notification->note_en = "The trip is finished";
            $Notification->note_ar = "تم انهاء الرحلة";
            $Notification->prcoss = "MyOrders";
            $Notification->seen = '0';
            $Notification->save();
            
            $Driver= new Driver();
            $Driver->driver_id=auth('api')->user()->id;
            $Driver->Order_id=$order->id;
            $Driver->Order_Cost=$order->cost;
            $Driver->save();
        }
        
        

        return $this->sendResponse($order, 'order taken');
    }
    
    public function UserAccounting (Request $request)
    {
        
        $range=$request->input('range');
        
        if($range=="yearly"){
            $where_start = date("Y-m-d",strtotime("-1 Days"));
            $where_end = date("Y-m-d",strtotime("+1 Days"));
            $date_format="created_at as date";
        }
        
        if($range=="week"){
            $monday = strtotime("last monday");
            $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
            $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
            
            $where_start = date("Y-m-d",$monday);
            $where_end = date("Y-m-d",$sunday);
            $date_format="SUBSTRING(dayname(created_at), 1, 3) as date";
        }
        
        if($range=="month"){
            $where_start= date("Y-m-d",strtotime('first day of this year'));
            $where_end= date("Y-m-d",strtotime('first day of next year'));
            $date_format="SUBSTRING(MONTHNAME(created_at), 1, 3) as date";
        }
        
        $Order = Order::where('user_id',auth('api')->user()->id)
        ->where(Order::raw("(date(created_at))"), ">", $where_start)
        ->where(Order::raw("(date(created_at))"), "<", $where_end)
        ->where('status','finished')
        ->groupBy('date')
        ->get([Order::raw("SUM(price) as sale"),Order::raw($date_format)]);
       
        
        if($range=="week"){
            $week=array(0=> 0,1=> 0,2=> 0,3 => 0,4=> 0,5=> 0,6=> 0);
            foreach ($Order as $key){
                switch ($key->date){
                    case"Mon":
                        $week[0]=$key->sale;
                        break;
                    case"Tue":
                        $week[1]=$key->sale;
                        break;
                    case"Wed":
                        $week[2]=$key->sale;
                        break;
                    case"Thu":
                        $week[3]=$key->sale;
                        break;
                    case"Fri":
                        $week[4]=$key->sale;
                        break;
                    case"Sat":
                        $week[5]=$key->sale;
                        break;
                    case"Sun":
                        $week[6]=$key->sale;
                        break;
                }
             }
             $data=$week;
        }
        
        if($range=="month"){
            $month=array(0=> 0,1=> 0,2=> 0,3 => 0,4=> 0,5=> 0,6=> 0,7=> 0,8=> 0,9=> 0,10 => 0,11=> 0);
            foreach ($Order as $key){
                switch ($key->date){
                    case"Jan":
                        $month[0]=$key->sale;
                        break;
                    case"Feb":
                        $month[1]=$key->sale;
                        break;
                    case"Mar":
                        $month[2]=$key->sale;
                        break;
                    case"Apr":
                        $month[3]=$key->sale;
                        break;
                    case"May":
                        $month[4]=$key->sale;
                        break;
                    case"Jun":
                        $month[5]=$key->sale;
                        break;
                    case"Jul":
                        $month[6]=$key->sale;
                        break;
                    case"Aug":
                        $month[7]=$key->sale;
                        break;
                    case"Sep":
                        $month[8]=$key->sale;
                        break;
                    case"Oct":
                        $month[9]=$key->sale;
                        break;
                    case"Nov":
                        $month[10]=$key->sale;
                        break;
                    case"Dec":
                        $month[11]=$key->sale;
                        break;
                }
            }
            $data=$month;
        }
        
        return $this->sendResponse($data, 'order taken');
    }
    
    public function user_accounting()
    {
        $where_start= date("Y-m-d",strtotime('0 Days'));
//         $where_end= date("Y-m-d",strtotime('first day of next year'));
        
        $sales = Order::where('user_id',auth('api')->user()->id);
        $sales=$sales->where(Order::raw("(date(created_at))"), "<", $where_start)->sum('price');
//      $order = $Order->where('status','finished')->get() ;
//      $order = $Order->sum('price') ;
        
        $cost = Order::where('user_id',auth('api')->user()->id);
        $cost = $cost->where('status','finished');
        $cost=$cost->where(Order::raw("(date(created_at))"), "<", $where_start);
        $cost= $cost->where('payer','sender')->sum('cost');
        
        
        $Data=array(
            'Sales'=> $sales,
            'Cost'=> $cost,
        );
        
        return response()->json([
            "data" => $Data,
            "message" => "Get data successfully"
        ], 201);
        
        
    }
}
