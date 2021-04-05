<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\gallery;
use App\Models\Banner;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $banners = \DB::select("select * from banners ");
        $AllBanners= array();
        foreach ($banners as $banner){
            $banner->image='/Koha-Web/public'.$banner->image;
            $AllBanners[]=$banner;
        }
        return view('admin.banners.index')
        ->with('banners', $AllBanners);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        if($request->hasFile('image'))
        {
            if ($request->file('image')->isValid()) 
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
//                         $gallery = new gallery();
//                         $gallery->user_id = $request->input('user_id');
//                         $gallery->filepath = $file_path;
//                         $gallery->save();
                
                        $Banner= new Banner();
                        $Banner->name=$request->name;
                        $Banner->image=$file_path;
                        $Banner->Description=$request->Description;
                        $Banner->save();
                        
                    \Session::flash('message','Banner added successfully');
                    \Session::flash('class', 'alert-success');
                    return redirect()->route('admin.banners', app()->getLocale());
                    } 
            }
            else
            {
                \Session::flash('message','Error uploading banner, please try again ');
                \Session::flash('class', 'alert-danger');
                return view('admin.banners.create');
                
            }
        }
       
        
        
      
        return view('admin.banners.create');
       
    }

    public function edit(Request $request, $id)
    {
        if($request->has('name'))
        {
            \DB::update("update banners set name = '{$request->name}' where id='{$id}' ");
            if($request->hasFile('image'))
            {
                if ($request->file('image')->isValid())
                {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $name = md5(time().$file->getClientOriginalName()).".".$ext;
                    if($file->move("/var/www/html/Koha-Web/public/",$name))
                    {
                         \DB::update("update banners set image = '/files/{$name}' where id='{$id}' ");
            
            
                        \Session::flash('message','Banner modified successfully');
                        \Session::flash('class', 'alert-success');
                        return redirect()->route('admin.banners', app()->getLocale());
                    }
                    else
                    {
                        \Session::flash('message','Error uploading banner, please try again ');
                        \Session::flash('class', 'alert-danger');
                        return view('admin.banners.edit');
                    }
                     
            
                }
                else
                {
                    \Session::flash('message','Error uploading banner, please try again ');
                    \Session::flash('class', 'alert-danger');
                    return view('admin.banners.edit');
            
                }
            }
        }
        
        
        $banner = \DB::select("select * from banners where id='{$id}' ");
        $banner[0]->image='/var/www/html/Koha-Web/public'.$banner[0]->image;
        return view('admin.banners.edit')->with('banner' , $banner[0]);
    }

   
    public function delete($id)
    {
       \DB::delete("delete from banners where id='{$id}' ");
       \Session::flash('message','Banner deleted successfully');
       \Session::flash('class', 'alert-success');
       return redirect()->route('admin.banners', app()->getLocale());
    }
    
    
}
