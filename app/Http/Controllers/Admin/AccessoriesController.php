<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accessorie;
use App\Models\cite;
use App\Models\type;
use App\Models\gallery;
class AccessoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $Accessorie = Accessorie::all();
        $AllAccessorie=array();
        
        foreach ($Accessorie as $key){
            $key->image='/Koha-Web/public'.$key->image;
            $AllAccessorie[] =$key;
        }
        
        return view('admin.accessories.index')->with('Accessories', $AllAccessorie);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddPage()
    {
        $cite = cite::all();
        $type = type::all();
        
        return view('admin.accessories.create')
        ->with('cite', $cite)
        ->with('type', $type);
    }
    
    
    public function create(Request $request)
    {
        if(isset($_FILES["image"]["type"]))
        {
            $FILES = $_FILES["image"];
            
            //Send error
            if ($FILES['error'])
            {
                return response()->json(['error'=>'Invalid file']);
            }
            
            //Change file name
            $imageFileType = pathinfo($FILES["name"],PATHINFO_EXTENSION);
            $uniqid = uniqid();
            $file_path='/files/' . $uniqid .'.'.$imageFileType;
            $file = "/var/www/html/Koha-Web/public" .$file_path;
            
            //Upload file
            if(move_uploaded_file($FILES["tmp_name"], $file)){
                $gallery = new gallery();
                $gallery->user_id = @auth()->user()->id;
                $gallery->filepath = $file_path;
                $gallery->save();
            }
        }
        
        
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'location' => 'required',
            'status' => 'required',
            'Description' => 'required',
        ]);
        
        $Accessorie = new Accessorie();
        
        $Accessorie->name = $request->input('name');
        $Accessorie->image = $gallery->filepath;
        $Accessorie->location = $request->input('location');
        $Accessorie->price = $request->input('price');
        $Accessorie->status = $request->input('status');
        $Accessorie->user_id = @auth()->user()->id;
        $Accessorie->Description = $request->input('Description');
        $Accessorie->approve = 1;
       
        $Accessorie->save();
        //         dd($bid);
        return redirect()->route('admin.accessories', app()->getLocale());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
                $Accessorie = Accessorie::find($id);
                $Accessorie->image='/Koha-Web/public'.$Accessorie->image;
                $GetData = $this->getAccessorieResponse($Accessorie);
                $Accessorie->location=$GetData['citys'];
                
                return view('admin.accessories.show')->with([
                    'Accessorie' => $Accessorie,
                ]);
    }


    public function edit($id)
    {
                $Accessorie = Accessorie::find($id);
                
                return view('admin.accessories.edit')->with([
                    'Accessorie' => $Accessorie,
                ]);
    }

 
    public function update(Request $request, $id)
    {
        $Accessorie = Accessorie::find($id);
        
        $Accessorie->name = $request->input('name');
        $Accessorie->price = $request->input('price');
        $Accessorie->location = $request->input('location');
        $Accessorie->status = $request->input('status');
        $Accessorie->Description = $request->input('Description');
        $Accessorie->save();
        return redirect()->route('admin.accessories', app()->getLocale());
    }

    
    public function destroy($id)
    {
            $Accessorie = Accessorie::find($id);
            if ($Accessorie->delete()) {
                \Session::flash('message', $Accessorie->name . ' Has been Deleted');
                \Session::flash('class', 'alert-success');
            } else {
                \Session::flash('message', 'Error deleting the user');
                \Session::flash('class', 'alert-danger');
            }
            return redirect()->route('admin.accessories', app()->getLocale());
    }
    
    private function getAccessorieResponse($Accessorie)
    {
        
        //         if($lan=='en'){
        $data = [
            'citys' =>$Accessorie->citys()->get()->pluck('name_en')->toArray()[0],
            'phone'=>$Accessorie->user()->get()->pluck('phone')->toArray()[0],
            'email'=>$Accessorie->user()->get()->pluck('email')->toArray()[0],
            'name'=>$Accessorie->user()->get()->pluck('name')->toArray()[0],
        ];
        //         }
        //         else{
        //             $data = [
        //                 'type' => $Advertise->types()->get()->pluck('name_ar')->toArray()[0],
        //                 'citys' => $Advertise->citys()->get()->pluck('name_ar')->toArray()[0],
        //                 'phone'=>$Advertise->user()->get()->pluck('phone')->toArray()[0]
        //             ];
        //         }
        return $data;
        }
        
}
