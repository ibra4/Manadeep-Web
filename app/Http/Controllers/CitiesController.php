<?php

namespace App\Http\Controllers;

use App\Models\cite;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    // 'index', 'store', 'create', 'edit', 'update'

    public function index(Request $request)
    {
        $cities = cite::all();
        return view('admin.cities.index')->with('cities', $cities);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'lng' => 'required',
            'lat' => 'required',
        ]);

        $city = new City();

        $city->name_en = $request->name_en;
        $city->name_ar = $request->name_ar;
        $city->lat = $request->lat;
        $city->lng = $request->lng;

        $city->save();

        return redirect()->route('cities.index');
    }

    public function create(Request $request)
    {
        return view('admin.cities.create');
    }

    public function edit(Request $request)
    {
        dd("edit");
    }

    public function update(Request $request)
    {
        dd("update");
    }

    public function destroy(Request $request, cite $city)
    {
        $city->delete();
        return redirect()->route('cities.index');
    }

    public function citiesPricing(Request $request)
    {
        dd("hi");
    }
}
