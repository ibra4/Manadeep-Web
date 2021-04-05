<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;



class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $locations = \DB::select("select * from cites");


        return view('admin.locations.index')
        ->with('locations', $locations);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->has('name_ar') && $request->name_ar != "")
        {
            \DB::insert("insert into cites (name_ar, name_en ) values ( '{$request->name_ar}' , '{$request->name_en}' ) ");

            \Session::flash('message','Location added successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations', app()->getLocale());
        }



        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, $id)
    {

        if($request->has('name_ar') && $request->name_ar != "")
        {
            \DB::update("update cites set name_ar = '{$request->name_ar}' , name_en = '{$request->name_en}'  where id='{$id}' ");
            \Session::flash('message','Location modified successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations', app()->getLocale());
        }

        $location = \DB::select("select * from cites where id='{$id}' ");
        return view('admin.locations.edit')
        ->with('location' , $location[0]);
    }


    public function delete($id)
    {
        if(isset($id) && $id != "")
        {
            \DB::delete("delete from cites where id='{$id}' ");
            \Session::flash('message','Location deleted successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations', app()->getLocale());

        }
        else
        {
            \Session::flash('message','Invalid Location ID');
            \Session::flash('class', 'alert-danger');
            return redirect()->route('admin.locations', app()->getLocale());
        }

    }
}
