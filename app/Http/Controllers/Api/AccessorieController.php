<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accessorie;

class AccessorieController extends Controller
{
    public function index()
    {
        //
    }

   

    public function Get(Request $request)
    {
        $id = $request->input('id');
        $lang = $request->input('lang');
        
        $Accessorie = Accessorie::find($id);
//         $Accessorie ->save();
//         dd($request->input('lang'));
        $GetData = $this->getAccessorieResponse($Accessorie,$lang);
        $Accessorie->location=$GetData['citys'];
        $Accessorie->phone=$GetData['phone'];
        return response()->json([
            "data"=>$Accessorie,
            "message" => 'Get all Advertises successfully.'
        ], 200);
    }
    
    public function show($lang)
    {
        $Accessorie = Accessorie::where('approve',1)->orderBy('id','DESC')-> get();
        $data=array();
        
        foreach ($Accessorie as $item){
            $GetData = $this->getAccessorieResponse($item,$lang);
            $item->location=$GetData['citys'];
            $item->phone=$GetData['phone'];
            $data[]=$item;
        }
        return response()->json([
            "data"=>$data,
            "message" => 'Get all Accessories successfully.'
        ], 200);
    }
    
    public function Filter(Request $request)
    {
        $Accessorie = Accessorie::where('approve',1);
        $data=array();
        
        if ($request->has('Age')) {
            $Accessorie->where('Age', $request->input('Age'));
        }
        if ($request->has('price')) {
            
            $Accessorie->where('price','<',$request->input('price'));
        }
        if ($request->has('location')) {
            $Accessorie->where('location', $request->input('location'));
        }
        
        switch ($request->input('sort')){
            case 'Low Price':
                $Accessorie = $Accessorie -> orderBy('price')-> get();
                break;
            case 'Hight Price':
                $Accessorie = $Accessorie -> orderBy('price','DESC')-> get();
                break;
            case 'Newest':
                $Accessorie = $Accessorie -> orderBy('id','DESC')-> get();
                break;
            case 'Oldest':
                $Accessorie = $Accessorie -> orderBy('id')-> get();
        }

        foreach ($Accessorie as $item){
            $GetData = $this->getAccessorieResponse($item,$request->input('lang'));
            $item->location=$GetData['citys'];
            $data[]=$item;
        }
        return response()->json([
            "data"=>$data,
            "message" => 'Get all Accessories successfully.'
        ], 200);
    }
    
    
    private function getAccessorieResponse( $Accessorie,$lan)
    {
        
        if($lan=='en'){
            $citys=$Accessorie->citys()->get()->pluck('name_en')->toArray()[0];
        }else{
            $citys= $Accessorie->citys()->get()->pluck('name_ar')->toArray()[0];
        }
            $data = [
                'citys' =>$citys,
                'phone'=>$Accessorie->user()->get()->pluck('phone')->toArray()[0]
            ];
        
        return $data;
    }
}
