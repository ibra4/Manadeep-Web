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

class PartnersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $partners = \DB::select("select * from users where id in ( select user_id from role_user where role_id = '4' ) ");
        $categories = \DB::select("select * from sub_packages where package_id = '12' ");

        return view('admin.partners.index')
        ->with('partners', $partners)
        ->with('partner_categories' ,$categories);
    }

    public function edit(Request $request, $id)
    {
       
        $partner = User::find($id);
        $categories = \DB::select("select * from sub_packages where package_id = '12' ");
        
        
        if($request->has('name'))
        {
            if($request->has('password') && $request->password != "")
            {
                $validator = Validator::make($request->all(), [
                    'phone_number' => 'required',
                    'name' => 'required',
                    'password' => 'min:6|required_with:password2|same:password2',
                    'password2' => 'min:6',
                    'partner_sub_package_id' => 'required'
                    
                ]);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                    'phone_number' => 'required',
                    'name' => 'required',
                    'partner_sub_package_id' => 'required'
          
                ]);
            }
        
            if ($validator->fails()) {
                $vals = json_decode($validator->errors(),1);
                $msg = "";
                 
                foreach($vals as $key => $val){
                    $msg .= str_replace('password2','Password Confirmation',$val[0]) ."";
                }
                $partner = User::find($id);
                \Session::flash('message','Error modifying partner: '.$msg);
                \Session::flash('class', 'alert-danger');
                return view('admin.partners.edit')->with(['partner' => $partner,
                    'partner_categories' => $categories
                ]);
            }
        
            $input = $request->all();
        
        
            
            $partner = User::find($id);
            $partner->name = $request->input('name');
            $partner->phone_number = $request->input('phone_number');
            $partner->partner_sub_package_id = $request->input('partner_sub_package_id');
            if($request->password != "")
                $partner->password = bcrypt($request->input('password'));
            $partner->email = $request->input('email');
            $partner->save();
        
            $partner = User::find($id);
        
             
            \Session::flash('message', 'Partner ' .$partner->name . ' has been modified');
            \Session::flash('class', 'alert-success');
             
            return view('admin.partners.edit')->with(['partner' => $partner,
                'partner_categories' => $categories
            ]);
             
        }
        

        return view('admin.partners.edit')->with([
            'partner' => $partner,
            'partner_categories' => $categories
        ]);
    }
    
    
    public function create(Request $request)
    {
        $categories = \DB::select("select * from sub_packages where package_id = '12' ");
    
        if($request->has('name'))
        {
            $validator = Validator::make($request->all(), [
                'phone_number' => 'required|unique:users',
                'name' => 'required',
                'password' => 'min:6|required_with:password2|same:password2',
                'password2' => 'min:6',
                'partner_sub_package_id' => 'required'
            ]);
    
            if ($validator->fails()) {
                $vals = json_decode($validator->errors(),1);
                $msg = "";
                 
                foreach($vals as $key => $val){
                    $msg .= str_replace('password2','Password Confirmation',$val[0]) ."";
                }
                \Session::flash('message','Error Creating partner: '.$msg);
                \Session::flash('class', 'alert-danger');
                return view('admin.partners.create') ->with('partner_categories' ,$categories);
            }
    
            $input = $request->all();
    
            $input['phone_number'] = $input['phone_number'];
            $input['password'] = bcrypt($input['password']);
            $input['name'] = $request->input('name');
            $input['partner_sub_package_id'] = $request->input('partner_sub_package_id');
            // @todo: Handle Verification
            $input['verification_code'] = '1234';
            
            
    
            $user = User::create($input);
    
            $role = '4';
            $user->roles()->attach($role);
            $user->partner_sub_package_id = $request->input('partner_sub_package_id');
            $user->save();
            
            
             
            \Session::flash('message', 'Partner ' .$user->name . ' has been created');
            \Session::flash('class', 'alert-success');
             return redirect()->route('admin.partners', app()->getLocale());
            
        }
    
        return view('admin.partners.create')
        ->with('partner_categories' ,$categories);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partner = User::find($id);
        $partner->roles()->detach();
        if ($partner->delete()) {
           \Session::flash('message', $partner->name . ' has been Deleted');
           \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error deleting the partner');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.partners', app()->getLocale());
    }

    public function block($id)
    {
        $partner = User::find($id);
        $partner->is_active = 0;
        
        if ($partner->save()) {
            \Session::flash('message', $partner->name . ' has been Blocked');
            \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error blocking the partner');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.partners', app()->getLocale());
    }
    
    public function managecategories()
    {
        $categories = \DB::select("select * from sub_packages where package_id = '12' ");
       
        return view('admin.partners.categories')
        ->with('partner_categories' ,$categories);
    }
    
    public function managecategoriescreate(Request $request)
    {
        if($request->has('name_en') && $request->name_en != "")
        {
            
            \DB::insert("insert into sub_packages ( name_ar, name_en, package_id ) values ( '{$request->name_ar}' , '{$request->name_en}' , '12' ) ");
            \Session::flash('message', 'Category has been created');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.partners.managecategories', app()->getLocale());
        }
       
       
    }
    
    public function managecategoriesmodify(Request $request)
    {
        if($request->has('name_en') && $request->name_en != "" && $request->has('id') && $request->id != "")
        {
            
            \DB::insert("update sub_packages set name_ar =  '{$request->name_ar}',  name_en = '{$request->name_en}' where id = '{$request->id}' ");
            \Session::flash('message', 'Category modified successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.partners.managecategories', app()->getLocale());
        }
       
       
    }
    
    public function managecategoriesdelete($id)
    {
        if(isset($id) && $id != "")
        {
            
            \DB::delete("delete from sub_packages where id = '{$id}' ");
            \Session::flash('message', 'Category deleted successfully');
            \Session::flash('class', 'alert-success');
            return redirect()->route('admin.partners.managecategories', app()->getLocale());
        }
       
       
    }
}
