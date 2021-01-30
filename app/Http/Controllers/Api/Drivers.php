<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\commission;

class Drivers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function driver_accounting()
    {
        $where_in= date("Y-m-d",strtotime("0 Days"));
        $Driver=Driver::where(Driver::raw("(date(created_at))"), "=", $where_in);
        $Driver=$Driver->where('driver_id',auth('api')->user()->id)->sum('Order_Cost');
        
        $commission = commission::where('commission_name','Driver_commission')->get('commission_value');
        $commissionVal= $commission[0]['commission_value'];
        
        $total=($Driver*$commissionVal);
        
        $commissionVal=$commissionVal*100;
        
        $Data=array(
            'Driver_total'=> $Driver,
            'commission'=> "$commissionVal",
            'total' => "$total",
        );
        
        return response()->json([
            "data" => $Data,
            "message" => "Get data successfully"
        ], 201);
        
        
    }
    
    
}
