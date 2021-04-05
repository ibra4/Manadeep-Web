<?php
namespace App\Http\Controllers\Admin;

// namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Rate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Validator;
use App\Models\cite;
use App\Models\type;

class PartnersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = type::all();
        
        return view('admin.partners.categories')
        ->with('type' ,$type);
    }
    
    public function managecategories()
    {
        $type = type::all();
     
        return view('admin.partners.categories')
        ->with('type' ,$type);
    }
    
    public function managecategoriescreate(Request $request)
    {
        if($request->has('name_en') && $request->name_en != "")
        {
            $type = new type ();
            $type-> name_ar = $request->name_en;
            $type-> name_en= $request->name_ar;
            $type-> save();
            \Session::flash('message', 'Category has been created');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.partners.managecategories', app()->getLocale());
        }
       
       
    }
    
    public function managecategoriesmodify(Request $request)
    {
        if($request->has('name_en') && $request->name_en != "" && $request->has('id') && $request->id != "")
        {
            $type =type::find($request->has('id'));
            $type-> name_ar=$request->has('name_ar');
            $type-> name_en =$request->has('name_en');
            $type-> save();
            \Session::flash('message', 'Category modified successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.partners.managecategories', app()->getLocale());
        }
       
       
    }
    
    public function managecategoriesdelete($id)
    {
        dd($id);
       
            \DB::delete("delete from types where id = '{$id}' ");
            \Session::flash('message', 'Category deleted successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.partners.managecategories', app()->getLocale());
       
       
       
    }
}
