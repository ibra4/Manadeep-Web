<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\gallery;

class MainController extends Controller
{
    public function index()
    {
        $banner =Banner::all();
        
        return response()->json([
            "data"=>$banner,
            "message" => 'Get data successfully.'
        ], 200);
    }
    
    public function uploadImage(Request $request)
    {
        $img = $request->input('image');
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        #================ The resize image  ===============#
        $source = imagecreatefromstring($image_base64);
        list($width, $height) = getimagesizefromstring ($image_base64);
        $newwidth = $width/5;
        $newheight = $height/5;
        
        $destination = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
        $uniqid = uniqid();
        $file_path='/files/' . $uniqid . '.' . $image_type;
        $file = public_path() .$file_path;
        imagejpeg($destination, $file, 100);
        
        #================ The resize image  ===============#
        $gallery = new gallery();
        
        $gallery->user_id = $request->input('user_id');
        $gallery->filepath = $file_path;
        
        $gallery->save();
        
        return response()->json([
            "data"=>$gallery,
            "message" => 'uploaded successfully.'
        ], 200);
        
    }
}
