<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:10|numeric',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $input = $request->all();

        Contact::create($input);
        $data = [
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'body' => $request->message
          ];

        //  Send mail to admin
        Mail::send('email', $data, function($message) use ($request){
            $message->from($request->email);
            $message->to('support@housingstreet.com', 'Admin')->subject($request->get('subject'));
        });

        return response() -> json ([
            'message' => 'The email has been sent'
        ], 201); 
    }
}
