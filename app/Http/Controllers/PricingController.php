<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pricings = Pricing::all();
        return view('admin.pricing.index', [
            'pricings' => $pricings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all('id', 'name_ar');
        return view('admin.pricing.add-edit', ['cities' => $cities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'city1' => 'required|different:city2',
            'city2' => 'required|different:city1',
            'price' => 'required'
        ]);

        $pricing = Pricing::where(function ($query) use ($request) {
            $query->where('city_id_1', $request->city1)
                ->Where('city_id_2', $request->city2);
        })->orWhere(function ($query) use ($request) {
            $query->where('city_id_1', $request->city2)
                ->Where('city_id_2', $request->city1);
        })->get()->first();
        if ($pricing) {
            return redirect()->route('cities-pricing.index');
        }

        $pricing = new Pricing();
        $pricing->city_id_1 = $request->city1;
        $pricing->city_id_2 = $request->city2;
        $pricing->price = $request->price;

        $pricing->save();

        return redirect()->route('cities-pricing.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pricing = Pricing::find($id);
        return view('admin.pricing.show', ['pricing' => $pricing]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pricing = Pricing::find($id);
        $cities = City::all('id', 'name_ar');
        return view('admin.pricing.add-edit', ['pricing' => $pricing, 'cities' => $cities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'city1' => 'required|different:city2',
            'city2' => 'required|different:city1',
            'price' => 'required'
        ]);

        $pricing = Pricing::where(function ($query) use ($request) {
            $query->where('city_id_1', $request->city1)
                ->Where('city_id_2', $request->city2);
        })->orWhere(function ($query) use ($request) {
            $query->where('city_id_1', $request->city2)
                ->Where('city_id_2', $request->city1);
        })->get()->first();
        if ($pricing) {
            return redirect()->route('cities-pricing.index');
        }

        $pricing = Pricing::find($id);
        $pricing->city_id_1 = $request->city1;
        $pricing->city_id_2 = $request->city2;
        $pricing->price = $request->price;

        $pricing->save();

        return redirect()->route('cities-pricing.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pricing = Pricing::find($id);

        $pricing->delete();

        return redirect()->route('cities-pricing.index');
    }
}
