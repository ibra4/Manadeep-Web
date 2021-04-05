<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\cite;
use App\Models\type;
use App\Models\BidPrice;
use App\Models\User;

class BidController extends Controller
{
   
    public function index()
    {
        $cite = cite::all();
        $type = type::all();
        
        $data=array(
            'cites' => $cite,
            'types' => $type);
        
        return response()->json([
            "data"=>$data,
            "message" => 'Get all Bids successfully.'
        ], 200);
    }

   
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'estimate_price' => 'required',
            'image' => 'required',
            'location' => 'required',
            'sex' => 'required',
            'Age' => 'required',
            'type' => 'required',
            'user_id' => 'required',
            'Description' => 'required',
            'Bid_time' => 'required'
        ]);
       
        $bid = new Bid();
        
        $bid->name = $request->input('name');
        $bid->estimate_price = $request->input('estimate_price');
        $bid->image = $request->input('image');
        $bid->location = $request->input('location');
        $bid->sex = 'male';
        $bid->Age = $request->input('Age');
        $bid->type = $request->input('type');
        $bid->user_id = $request->input('user_id');
        $bid->Description = $request->input('Description');
        $bid->Bid_time = $request->input('Bid_time');
        $bid->approve = 1;
        $bid->seen = 0;

        $bidTime=$request->input('Bid_time');
        $date1 = date("Y-m-d H:i:s");
        $date2 = date("Y-m-d H:i:s",strtotime("+$bidTime days",strtotime($date1)));

        $bid->StartBidDate = $date1;
        $bid->EndBidDate = $date2;
        $bid->save();
        
        return response()->json([
            "data"=>$bid,
            "message" => 'The Bid added successfully.'
        ], 200);
    }

   
    public function showBids()
    {
        $bid = Bid::where('approve',1)->orderBy('id','DESC')-> get();
        $allbids=array();
        foreach ($bid as $key){
            $Bid_time= $key->Bid_time;
            $date1 = strtotime(date("Y-m-d H:i:s"));
            $date2 = strtotime("+$Bid_time days",strtotime($key->StartBidDate));
            $date3= $date2 - $date1;
            $key->Bid_time=$date3;
            
            if($date3> 0)
                $allbids[]=$key;
        }
        
        return response()->json([
            "data"=>$allbids,
            "message" => 'Get all Bids successfully.'
        ], 200);
    }
    
    public function showFinishedBids()
    {
        
        $user = array();
        $data= array ();
        
        $bid = Bid::where('approve',1)
                    ->whereDate('EndBidDate', '<', date('Y-m-d H:i:s'))
                    ->orderBy('id','DESC')-> get();
        
        foreach ($bid as $key){
            
            $BidPrice=BidPrice::where('bid_id',$key->id)->orderBy('price','DESC')->first();
            if($BidPrice !==null){
                $user=User::find($BidPrice->user_id);
                $key->owner = $user->name;
            }
            else{
                continue;
            }
            $data[]=$key;
        }
        
        
                  
                   
        return response()->json([
            "data"=>$data,
            "message" => 'Get all Bids successfully.'
        ], 200);
    }
    
    public function Getbid($id)
    {
        $bid = Bid::find($id);
        $bid->seen = ++$bid->seen;
        $bid->save();
        
        $Bid_time= $bid->Bid_time;
        $date1 = strtotime(date("Y-m-d H:i:s"));
        $date2 = strtotime("+$Bid_time days",strtotime($bid->StartBidDate));
        $date3= abs($date2 - $date1);
        $bid->Bid_time=$date3;
        
        // seen count
        
        $BidPrice=BidPrice::where('bid_id',$bid->id)->orderBy('id','DESC')->get();
        
        $data= array (
            'Bid' =>$bid,
            'BidPrice'=>$BidPrice,
        );
        
        return response()->json([
            "data"=>$data,
            "message" => 'Get all Bids successfully.'
        ], 200);
    }
    
    public function AddBid(Request $request)
    {
        $bid = Bid::find($request->input('id'));
        
        $bid->last_price  !== null ? $OldPrice =$bid->last_price : $OldPrice = $bid->estimate_price;
     
        $NewPrice = $request->input('new_price');
        
        if($OldPrice >= $NewPrice){

            return response()->json([
                "message" => "you should add a price that's higher than the previous one"
            ], 205);
            
        }
        else{
             $bid->last_price=$NewPrice;
             $bid->save();
             
             $BidPrice = new BidPrice();
             $BidPrice->user_id = $request->input('user_id');
             $BidPrice->bid_id = $bid->id;
             $BidPrice->price = $NewPrice;
             $BidPrice->save();
             
             return response()->json([
                    "data"=>$BidPrice ,
                    "message" => 'The Bid added successfully.'
                ], 200);
            }
        }
        
        public function showLastBid()
        {
            $bid = Bid::where('approve',1)->orderBy('id','DESC')->limit(5)-> get();
            $allbids=array();
            foreach ($bid as $key){
                $Bid_time= $key->Bid_time;
                $date1 = strtotime(date("Y-m-d H:i:s"));
                $date2 = strtotime("+$Bid_time days",strtotime($key->StartBidDate));
                $date3= $date2 - $date1;
                $key->Bid_time=$date3;
                
                if($date3> 0)
                    $allbids[]=$key;
            }
            
            return response()->json([
                "data"=>$allbids,
                "message" => 'Get all Bids successfully.'
            ], 200);
        }
        
        public function FilterBid(Request $request)
        {
            $bid = Bid::where('approve',1);
           
            if ($request->has('Age')) {
                $bid->where('Age', $request->input('Age'));
            }
            if ($request->has('price')) {
                
                $bid->where(function($q) use($request) {
                    return $q
                    ->where('estimate_price','<',$request->input('price'))
                    ->orWhere('last_price','<',$request->input('price'));
                    
                });
            }
            if ($request->has('location')) {
                $bid->where('location', $request->input('location'));
            }
            
            switch ($request->input('sort')){
                case 'Low Price':
                    $bid = $bid -> orderBy('estimate_price')-> get();
                    break;
                case 'Hight Price':
                    $bid = $bid -> orderBy('estimate_price','DESC')-> get();
                    break;
                case 'Newest':
                    $bid = $bid -> orderBy('id','DESC')-> get();
                    break;
                case 'Oldest':
                    $bid = $bid -> orderBy('id')-> get();
            }
            
            $allbids=array();
            foreach ($bid as $key){
                $Bid_time= $key->Bid_time;
                $date1 = strtotime(date("Y-m-d H:i:s"));
                $date2 = strtotime("+$Bid_time days",strtotime($key->StartBidDate));
                $date3= $date2 - $date1;
                $key->Bid_time=$date3;
                
                if($date3> 0)
                    $allbids[]=$key;
            }
            
            return response()->json([
                "data"=>$allbids,
                "message" => 'Get all Bids successfully.'
            ], 200);
        }

}
