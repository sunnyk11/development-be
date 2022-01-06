<?php

namespace App\Http\Controllers\Api;

use App\Models\guest_user_feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\eventtracker;
use App\Models\product;
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
        $user_id = Auth::user()->id;
        return response()->json([
            'data' => guest_user_feedback::where('user_id', $user_id)->get()
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

    
    public function testimonial(){
        return response()->json([
            'data' => guest_user_feedback::with('UserDetail')->where('stars', '5')->orderBy('id', 'desc')->take(3)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        // return $request->all();
        $request-> validate([
            'product_id' => 'required',
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
    public function destroy($id)
    {
        $review = guest_user_feedback::where('id', $id);
        $review->delete();
        return response() -> json ([
            'message' => 'The review has been deleted.'
        ]); 
    }
}
