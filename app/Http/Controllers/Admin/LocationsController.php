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

        $locations = \DB::select("select * from cities");


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
            \DB::insert("insert into cities (name_ar, name_en, lng, lat ) values ( '{$request->name_ar}' , '{$request->name_en}', '{$request->lng}' , '{$request->lat}' ) ");

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
            \DB::update("update cities set name_ar = '{$request->name_ar}' , name_en = '{$request->name_en}' , lng = '{$request->lng}' , lat = '{$request->lat}' where id='{$id}' ");
            \Session::flash('message','Location modified successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations', app()->getLocale());
        }

        $location = \DB::select("select * from cities where id='{$id}' ");
        return view('admin.locations.edit')
        ->with('location' , $location[0]);
    }


    public function delete($id)
    {
        if(isset($id) && $id != "")
        {
            \DB::delete("delete from cities where id='{$id}' ");
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


    public function pricing()
    {
        // pricing lists
        $pricings = \DB::select("select * from pricings ");
        $locations = \DB::select("select * from cities");

        $location_data = [];

        // reorganize the locations by ID
        foreach($locations as $location)
        {
            $location_data[$location->id] = ['name_ar' => $location->name_ar, 'name_en' => $location->name_en];
        }

        $bulk_pricing = \DB::select("select * from bulk_pricing_m order by m_start");

        return view('admin.locations.pricing')
        ->with('pricings' , $pricings)
        ->with('cities', $location_data)
        ->with('bulk_pricing', $bulk_pricing);

    }

    public function pricingcreate(Request $request)
    {

        if($request->has('location1') && $request->location1 != "")
        {
            //  check if combination exists
            $check = \DB::select("select * from pricings where ( city_id_1 = '{$request->location1}' and city_id_2 = '{$request->location2}' ) or
                 ( city_id_1 = '{$request->location2}' and city_id_2 = '{$request->location1}'   ) ");

            if(count($check) > 0)
            {
                // just update
                \DB::update("update pricings set price='{$request->price}' where id='{$check[0]->id}' ");
            }
            else
            {
                \DB::insert("insert into pricings ( city_id_1 , city_id_2, price) values( '{$request->location1}', '{$request->location2}', '{$request->price}' ) ");
            }

            \Session::flash('message','Pricing saved successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations.pricing', app()->getLocale());

        }



        $locations = \DB::select("select * from cities");



        return view('admin.locations.pricingcreate')
        ->with('locations' , $locations);


    }


    public function pricingedit(Request $request, $id)
    {

        if($request->has('location1') && $request->location1 != "")
        {

           \DB::update("update pricings set price='{$request->price}' , city_id_1 = '{$request->location1}' , city_id_2 = '{$request->location2}' where id='{id}' ");


            \Session::flash('message','Pricing saved successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations.pricing', app()->getLocale());





        }

        $locations = \DB::select("select * from cities");
        $pricing = \DB::select("select * from pricings where id='{$id}'   ");
        return view('admin.locations.pricingedit')
        ->with('locations' , $locations)
        ->with('pricing', $pricing[0]);

    }

    public function pricingdelete($id)
    {

            \DB::delete("delete from pricings where id='{$id}' ");
            \Session::flash('message','Pricing deleted successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations.pricing', app()->getLocale());


    }

    public function pricingcreatebulk(Request $request)
    {

        if($request->has('price') && $request->price != "")
        {
            \DB::insert("insert into bulk_pricing_m ( m_start, m_end, price ) values ( '{$request->m_start}' , '{$request->m_end}', '{$request->price}' )");
            \Session::flash('message','Pricing added successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations.pricing', app()->getLocale());
        }



        return view('admin.locations.pricingbulkcreate');


    }


    public function pricingeditbulk(Request $request, $id)
    {

        if($request->has('price') && $request->price != "")
        {
            \DB::insert("update bulk_pricing_m set m_start = '{$request->m_start}' , m_end = '{$request->m_end}', price= '{$request->price}' where id='{$id}' ");
            \Session::flash('message','Pricing updated successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations.pricing', app()->getLocale());
        }


        $pricing = \DB::select("select * from bulk_pricing_m where id='{$id}'");

        return view('admin.locations.pricingbulkedit')
        ->with('pricing',$pricing[0]);


    }

    public function pricingdeletebulk($id)
    {


            \DB::insert("delete from bulk_pricing_m  where id='{$id}' ");
            \Session::flash('message','Pricing deleted successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.locations.pricing', app()->getLocale());




    }




}
