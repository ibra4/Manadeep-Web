<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orderassociatl;
use App\Models\OrderAssociate;
use App\Models\User;
use App\Models\AssociateStatu;

class associate_orders extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hide($id)
    {
//         die($id);
        $orders = OrderAssociate::where('id','=',$id)->get();
        
        $hide= new AssociateStatu();
        $hide->user_id = auth('api')->user()->id;
        $hide->order_id = $orders[0]->id;
        $hide->status = "canceled";
        $hide->save();
        
        return response()->json([
            "data" => $hide,
            "message" => "success"
        ], 201);
    }
    
    public function index()
    {
        //
        
        return "xxxx0";
    }

    public function getActiveOrder(Request $request)
    {
            $HideOrder=array();
            $Hide = AssociateStatu::where('status', 'canceled')
            ->where('user_id', auth('api')->user()->id)
            ->get('order_id');
            
            foreach ($Hide as $key){
                $HideOrder[]=$key->order_id;
            }
            
            $where_in = 'in_progress';
            $orders = OrderAssociate::where('status', $where_in);
            if(count($HideOrder)>1){
                $orders = $orders -> whereNotIn('id',$HideOrder );
            }
            $orders = $orders -> newQuery()->with([
                'user' => function ($query) {
                $query->select('id', 'name', 'phone_number');
                },])->get();
                
        return response()->json([
            "data" => $orders,
            "message" => "success"
        ], 201);
    }
    
    public function MyOrder(Request $request)
    {
        $orders = OrderAssociate::where('status','!=', 'in_progress');
        $orders = $orders ->where('associate_id', auth('api')->user()->id);
//         $orders = $orders ->where('associate_id', 41);
        $orders = $orders -> newQuery()->with([
            'user' => function ($query) {
            $query->select('id', 'name', 'phone_number');
            },])->get();
            
            
            return response()->json([
                "data" => $orders,
                "message" => "success"
            ], 201);
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'toLat' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'toLng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'toName' => 'required',
            'package' => 'required',
            'subPackages' => 'required',
            'comments' => 'required',
            
        
        ]);
        
        $Orderassociatl = new OrderAssociate();
        
        $Orderassociatl->location = $request->input('toLat') . ',' . $request->input('toLng');
        $Orderassociatl->package_name = $request->input('package');
        $Orderassociatl->SubPackage_name = $request->input('subPackages');
        $Orderassociatl->locationName = $request->input('toName');
        $Orderassociatl->user_id = auth('api')->user()->id;
        $Orderassociatl->status = 'in_progress';
        $Orderassociatl->comments = $request->input('comments');
        
        $Orderassociatl->save();
        
        return response()->json([
            "data" => $Orderassociatl,
            "message" => "created successfully"
            ], 201);
//         $this->sendResponse($Orderassociatl, 'created successfully');
    }

    public function get($id)
    {
        $orders = OrderAssociate::where('id','=',$id)->with([
            'user' => function ($q) {
            $q->select('id', 'name','phone_number');
            }])->get();
            
            return response()->json([
                "data" => $orders,
                "message" => 'success'
            ], 201);
    }
    public function update(Request $request)
    {

        $request->validate([
            'ID' => 'required',
            'status' => 'required',
        ]);
        
        $Orderassociatl = OrderAssociate::find($request->input('ID'));
        
        if ($request->has('status')) {
            if($request->input('status')=='accept'){
                $Orderassociatl->status = $request->input('status');
                $Orderassociatl->associate_id = auth('api')->user()->id;
                $Orderassociatl->save();
            }
            if($request->input('status')=='finished'){
                $Orderassociatl->status = $request->input('status');
                $Orderassociatl->associate_id = auth('api')->user()->id;
                $Orderassociatl->save();
            }
        }  
//         $Orderassociatl->save();
        
        return response()->json([
            "data" => $Orderassociatl,
            "message" => "The Orderd accepted"
        ], 201);
        }

}
