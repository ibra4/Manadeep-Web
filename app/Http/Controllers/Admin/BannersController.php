<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;



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
        return view('admin.banners.index')
        ->with('banners', $banners);
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
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $name = md5(time().$file->getClientOriginalName()).".".$ext;
                if($file->move("/var/www/html/Manadeep-Web/public/files/",$name))
                {
                    \DB::insert("insert into banners (name, image ) values ( '{$request->name}', '/files/{$name}' ) ");
                    
                    
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
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
                    if($file->move("/var/www/html/Manadeep-Web/public/files/",$name))
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
