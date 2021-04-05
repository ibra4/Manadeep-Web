<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertise;

class AdvertiseController extends Controller
{
     
    public function index()
    {
        
    }

   
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'location' => 'required',
            'Age' => 'required',
            'type' => 'required',
            'user_id' => 'required',
            'Description' => 'required',
          ]);
       
        $Advertise = new Advertise();
        
        $Advertise->name = $request->input('name');
        $Advertise->price = $request->input('price');
        $Advertise->image = $request->input('image');
        $Advertise->location = $request->input('location');
        $Advertise->Age = $request->input('Age');
        $Advertise->type = $request->input('type');
        $Advertise->user_id = $request->input('user_id');
        $Advertise->Description = $request->input('Description');
        $Advertise->approve = 0;
        $Advertise->seen = 0;

        $Advertise->save();
        
        return response()->json([
            "data"=>$Advertise,
            "message" => 'The Advertise added successfully.'
        ], 200);
    }

   
    public function showAdvertises($lang)
    {
        $Advertise = Advertise::where('approve',1)->orderBy('id','DESC')-> get();
        $data=array();
        
        foreach ($Advertise as $item){
            $GetData = $this->getAdvertiseResponse($item,$lang);
//             dd($GetData);
            $item->type=$GetData['type'];
            $item->location=$GetData['citys'];
            $data[]=$item;
        }
        return response()->json([
            "data"=>$data,
            "message" => 'Get all Advertises successfully.'
        ], 200);
    }
    
    public function showLastAdvertises($lang)
    {
        $Advertise = Advertise::where('approve',1)->orderBy('id','DESC')->limit(5)
        -> get();
        $data=array();
        
        foreach ($Advertise as $item){
            $GetData = $this->getAdvertiseResponse($item,$lang);
            //             dd($GetData);
            $item->type=$GetData['type'];
            $item->location=$GetData['citys'];
            $data[]=$item;
        }
        return response()->json([
            "data"=>$data,
            "message" => 'Get all Advertises successfully.'
        ], 200);
    }
    
    public function GetAdvertise(Request $request)
    {
        $id = $request->input('id');
        $lang = $request->input('lang');
        
        $Advertise = Advertise::find($id);
        $Advertise->seen = ++$Advertise->seen;
        $Advertise->save();
        
        $GetData = $this->getAdvertiseResponse($Advertise,$lang);
        $Advertise->type=$GetData['type'];
        $Advertise->location=$GetData['citys'];
        
        return response()->json([
            "data"=>$Advertise,
            "message" => 'Get all Advertises successfully.'
        ], 200);
    }
    
    
    public function Filter(Request $request)
    {
        $Advertise = Advertise::where('approve',1);
        
        if ($request->has('Age')) {
            $Advertise->where('Age', $request->input('Age'));
        }
        if ($request->has('price')) {
            
            $Advertise->where('price','<',$request->input('price'));
        }
        if ($request->has('location')) {
            $Advertise->where('location', $request->input('location'));
        }
        
        switch ($request->input('sort')){
            case 'Low Price':
                $Advertise = $Advertise -> orderBy('price')-> get();
                break;
            case 'Hight Price':
                $Advertise = $Advertise -> orderBy('price','DESC')-> get();
                break;
            case 'Newest':
                $Advertise = $Advertise -> orderBy('id','DESC')-> get();
                break;
            case 'Oldest':
                $Advertise = $Advertise -> orderBy('id')-> get();
        }
        
        $data=array();
        
        foreach ($Advertise as $item){
            $GetData = $this->getAdvertiseResponse($item,$request->input('lang'));
            //             dd($GetData);
            $item->type=$GetData['type'];
            $item->location=$GetData['citys'];
            $data[]=$item;
        }
        return response()->json([
            "data"=>$data,
            "message" => 'Get all Advertises successfully.'
        ], 200);
    }
    
    private function getAdvertiseResponse( $Advertise,$lan)
    {
     
        if($lan=='en'){
            $data = [
                'type' => $Advertise->types()->get()->pluck('name_en')->toArray()[0],
                'citys' =>$Advertise->citys()->get()->pluck('name_en')->toArray()[0],
            ];
            }else{
                $data = [
                    'type' => $Advertise->types()->get()->pluck('name_ar')->toArray()[0],
                    'citys' => $Advertise->citys()->get()->pluck('name_ar')->toArray()[0],
                ];
            }
        return $data;
    }
    
}
