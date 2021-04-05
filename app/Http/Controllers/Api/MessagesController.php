<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\AdminMessage;

class MessagesController extends Controller
{
    public function NewContact(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        
        $contact= new Contact();
        
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->subject = $request->input('subject');
        $contact->message = $request->input('message');
        
        $contact->save();
        
        return response()->json([
            "data"=>$contact,
            "message" => 'The contact form added successfully.'
        ], 200);
    }
    
    public function NewAdminMessage(Request $request)
    {
        
        $request->validate([
            'user_id' => 'required',
            'message' => 'required',
        ]);
        
        $message= new AdminMessage();
        
        $message->user_id = $request->input('user_id');
        $message->message = $request->input('message');
        $message->save();
        
        return response()->json([
            "data"=>$message,
            "message" => 'The message sent successfully.'
        ], 200);
    }
}
