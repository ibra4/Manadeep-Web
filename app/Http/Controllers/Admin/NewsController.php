<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\gallery;
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $News = News::all();
        $AllNews=array();
        
        foreach ($News as $key){
            $key->image='/Koha-Web/public'.$key->image;
            $AllNews[] =$key;
        }
        return view('admin.news.index')->with('News', $AllNews);
    }

    
    

    public function AddPage()
    {
        return view('admin.news.create');
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
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $Accessorie = new News();
        
        $Accessorie->title = $request->input('title');
        $Accessorie->image = $gallery->filepath;
        $Accessorie->description = $request->input('description');
        $Accessorie->save();
       
        return redirect()->route('admin.news', app()->getLocale());
    }


    public function destroy($id)
    {
        $News = News::find($id);
        if ($News->delete()) {
            \Session::flash('message', $News->name . ' Has been Deleted');
            \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error deleting the user');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.news', app()->getLocale());
    }
}
