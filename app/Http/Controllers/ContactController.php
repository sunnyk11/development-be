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
            'phone' => $request->phone,
            'body' => $request->message
          ];

        //  Send mail to admin
        try{
            Mail::send('email', $data, function($message) use ($request){
            $message->from($request->email);
            $message->to(getenv("admin_email"), 'Admin')->subject($request->get('subject'));
            });

            return response() -> json ([
                'message' => 'The email has been sent',
                'status'=>201
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
         
    }
}
