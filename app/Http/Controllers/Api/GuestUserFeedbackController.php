<?php

namespace App\Http\Controllers\Api;

use App\Models\guest_user_feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\eventtracker;
use App\Models\product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Auth;

class GuestUserFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response()->json([
                'data' => guest_user_feedback::with('UserDetail')->get()
            ]);
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    public function search_data(Request $request){
        return response()->json([
                'data' => guest_user_feedback::with('UserDetail')->search($request)->paginate(5)
            ]);

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
    public function reviews_status_changes(Request $request){
        // return $request->user_id;
        try{
            $request -> validate([
                    'user_id' => 'required|integer'
                ]);
            $data= guest_user_feedback::select('status')->where('id', $request->user_id)->first();
            if($data['status']=='1'){
                guest_user_feedback::where('id', $request->user_id)->update(['status' =>'0']);
            }else{
                guest_user_feedback::where('id',$request->user_id)->update(['status' =>'1']);
            }
            return response()->json([
                'message' => 'User Reviews Status Chages',
                'status'=> 200
            ]);

           
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    
    public function testimonial(){
        try{
            return response()->json([
                'data' => guest_user_feedback::with('UserDetail')->where(['status'=>'1','stars'=> '5'])->orderBy('id', 'desc')->take(3)->get()
            ]); 
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        try{
            // return $request->all();
            $request-> validate([
                'product_id' => '',
                'stars' => 'required',
                'subject' => 'required',
                'content' => 'required',
                'user_id'=> 'required',
            ]);
            
          $data=$request->data;

            $property_name = product::select('build_name')->where('id', $request->product_id)->value('build_name');

            $guest_user_feedback = new guest_user_feedback([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'stars' => $request->stars,
                'subject' => $request->subject,
                'content' => $request->content,
            ]);

            $guest_user_feedback->save();
            eventtracker::create(['symbol_code' => '5', 'event' => Auth::user()->name.' gave a review on a property '. $property_name]);
            return response()->json([
                'message' => 'Review Submitted',
                'status'=> 200,
            ],200);
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }

    }
    public function product_review(Request $request)
    {
        $request -> validate([
            'id' => 'required',
        ]);

        return response()->json([
            'data' => guest_user_feedback::where('product_id', $request->id)->get(),
        ],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\guest_user_feedback  $guest_user_feedback
     * @return \Illuminate\Http\Response
     */
    public function show(guest_user_feedback $guest_user_feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\guest_user_feedback  $guest_user_feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(guest_user_feedback $guest_user_feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\guest_user_feedback  $guest_user_feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, guest_user_feedback $guest_user_feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\guest_user_feedback  $guest_user_feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
             $request -> validate([
                    'user_id' => 'required|integer'
                ]);
            $review = guest_user_feedback::where('id', $request->user_id)->delete();
            return response() -> json ([
                'message' => 'The review has been deleted.'
            ]); 
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
