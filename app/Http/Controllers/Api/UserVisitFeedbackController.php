<?php

namespace App\Http\Controllers\Api;

use App\Models\user_visit_feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class UserVisitFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        user_visit_feedback::create($input);
        $data = [
            'star_rating' => $request->star_rating,
            'system_ip' => $request->system_ip,
            'subject' => 'user feedback',
            'device_info' => $request->device_info,
            'body' => $request->message
          ];
          //  Send mail to admin
        try{
            Mail::send('feedback', $data, function($message) use ($request){
            $message->from(getenv("admin_email"));
            $message->to(getenv("admin_email"), 'Admin')->subject('user feedback');
            });

            return response() -> json ([
                'message' => 'visit user feedback store & email for admin',
                'status'=>201
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }
    public  function user_feedback_details(Request $request){

          try{

            $data=user_visit_feedback::where(['status'=>'1','system_ip'=>$request->ip_address])->get();
            return response()->json([
                    'data' => $data,
                    'status'=>200
                ], 200);

           }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user_visit_feedback  $user_visit_feedback
     * @return \Illuminate\Http\Response
     */
    public function show(user_visit_feedback $user_visit_feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user_visit_feedback  $user_visit_feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(user_visit_feedback $user_visit_feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user_visit_feedback  $user_visit_feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user_visit_feedback $user_visit_feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user_visit_feedback  $user_visit_feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(user_visit_feedback $user_visit_feedback)
    {
        //
    }
}
