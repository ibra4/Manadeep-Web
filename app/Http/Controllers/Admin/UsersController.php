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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        $All_user = array();

        foreach ($users as $user) {

            $All_user[] = $user;
        }

        return view('admin.users.index')->with('users', $All_user);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        $user_roles = \DB::select("select * from role_user where user_id = '{$id}' ");

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
            'user_roles' => $user_roles
        ]);
    }
    
    public function approval($id)
    {
        $user = User::find($id);
        $user->active = '1';
        
        $Email=$this->sendEmail($user->email);
            
        $user->save();
            \Session::flash('message', $user->name . ' Has been Actived');
            \Session::flash('class', 'alert-success');
        
        return redirect()->route('admin.users', app()->getLocale());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $user = User::find($id);
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }
        if ($request->has('password') && $request->password != null) {
            $user->password = Hash::make($request->password);
        }
        $user->name = $request->name;
        if ($request->has('email') && $request->email != null) {
            $user->email = $request->email;
        }
        if ($user->save()) {
            $request->session()->flash('success', $user->name . ' Has been Updated');
        } else {
            $request->session()->flash('error', 'Error updating the user');
        }

        return redirect()->route('admin.users', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->roles()->detach();
        if ($user->delete()) {
           \Session::flash('message', $user->name . ' Has been Deleted');
           \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error deleting the user');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.users', app()->getLocale());
    }

    public function Advertise($id)
    {

    }

    public function Approve(Request $request)
    {
        
        return $request->user();
    }
    
    private function sendEmail($to) {
        
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
        $mail->Body  = "The admin approved your account for Koha app , you can login now ";
        
        if(!$mail->Send()) {
            return json_encode(['status' => "ERROR", 'msg' => "Error while sending Email."]);
        } else {
            return json_encode(['status' => "success", 'msg' => "Email sent successfully"]);
        }
        
        
    }
}
