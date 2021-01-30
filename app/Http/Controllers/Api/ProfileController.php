<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\gallery;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    public function update(Request $request)
    {
        $user_id = auth('api')->user()->id;

        $user = User::find($user_id);

//             $user->location = $request->input('lat') . ',' . $request->input('lng');
            $user->nationality = $request->input('nationality');
            $user->qtr_id_no = $request->input('qtr_id_no');
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
            $user->image = $request->input('image');
            
            if($request->has('user')){
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->phone_number = $request->input('phone_number');
                $user->image = $request->input('image');
                
            }    
            
//             $user->locationName = $request->input('locationName');

        $user->save();

        return $this->sendResponse($user, 'updated successfully');
    }

    public function get(Request $request)
    {
        $user = auth('api')->user();
        return $this->sendResponse($user, 'success');
    }

    public function uploadImage(Request $request)
    {
        $img = $request->input('image');
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $uniqid = uniqid();
        $file_path='/files/' . $uniqid . '.' . $image_type;
        $file = public_path() .$file_path;
        file_put_contents($file, $image_base64);
        
        
        
        $gallery = new gallery();
        
        $gallery->user_id = auth('api')->user()->id;
        $gallery->filepath = $file_path;
        
        $gallery->save();
        
        
        return $this->sendResponse($gallery, 'uploaded successfully');
    }
}
