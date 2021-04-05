<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertise;
use App\Models\cite;
use App\Models\type;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Advertise = Advertise::all();
        $AllAdvertise=array();

        foreach ($Advertise as $key){
            $key->image='/Koha-Web/public'.$key->image;
            $AllAdvertise[] =$key;
        }

        return view('admin.advertises.index')->with('Advertises', $AllAdvertise);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Advertise = Advertise::find($id);
        $Advertise->image='/Koha-Web/public'.$Advertise->image;
        $GetData = $this->getAdvertiseResponse($Advertise);
       // dd($GetData);
        $Advertise->type=$GetData['type'];
        $Advertise->location=$GetData['citys'];

        return view('admin.advertises.show')->with([
            'Advertise' => $Advertise,
        ]);
    }

    public function approve($id)
    {
        $Advertise = Advertise::find($id);
        $Advertise ->approve = '1';

        $GetData = $this->getAdvertiseResponse($Advertise);
       // $Email=$this->sendEmail($GetData['email'], $GetData['name'],$Advertise->name);

        $Advertise->save();
        \Session::flash('message', $Advertise->name . ' Has been Actived');
        \Session::flash('class', 'alert-success');

        return redirect()->route('admin.advertises', app()->getLocale());

    }

    public function destroy($id)
    {
        $Advertise = Advertise::find($id);
        if ($Advertise->delete()) {
            \Session::flash('message', $Advertise->name . ' Has been Deleted');
            \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error deleting the user');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.advertises', app()->getLocale());
    }

    private function getAdvertiseResponse( $Advertise)
    {

        if(app()->getLocale()=='en'){
            $data = [
                'type' => $Advertise->types()->get()->pluck('name_en')->toArray()[0],
                'citys' => $Advertise->citys()->get()->pluck('name_en')->toArray()[0],
                'phone'=>$Advertise->user()->get()->pluck('phone')->toArray()[0]
            ];
        }
        else{
            $data = [
                'type' => $Advertise->types()->get()->pluck('name_ar')->toArray()[0],
                'citys' => $Advertise->citys()->get()->pluck('name_ar')->toArray()[0],
                'phone'=>$Advertise->user()->get()->pluck('phone')->toArray()[0]
            ];
        }
        return $data;
    }

    private function sendEmail($to,$user,$ads) {

        $mail = new PHPMailer ;

        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "app.koha3@gmail.com";
        $mail->Password   = "koha@123";

        $mail->IsHTML(true);
        $mail->AddAddress($to);
        $mail->SetFrom("app.koha3@gmail.com", "Koha");
        $mail->Subject = "your account on Koha app";
        $mail->Body  = "Hi $user,

        The admin approved your advertise '$ads' and the buyers will contact you by phone number.";

        if(!$mail->Send()) {
            return json_encode(['status' => "ERROR", 'msg' => "Error while sending Email."]);
        } else {
            return json_encode(['status' => "success", 'msg' => "Email sent successfully"]);
        }


    }
}
