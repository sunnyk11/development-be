<?php

namespace App\Http\Controllers\Api;

use App\Models\fixed_appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class FixedAppointmentController extends Controller
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
        try{
             $request->validate([
            'product_id' => 'required',
            'page_name'=>'required'
            ]);
            $fixed_appointment_data=[
                       'user_id'=>Auth::user()->id,
                       'Source'=>'Web',
                       'page_name'=>$request->page_name,
                       'product_id'=>$request->product_id,
            ];
             fixed_appointment::create($fixed_appointment_data);
                 return response()->json([
                    'message' =>'successfully fixed appointment store',
                    'data' =>$fixed_appointment_data,
                    'status'=>201
                ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }   

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\fixed_appointment  $fixed_appointment
     * @return \Illuminate\Http\Response
     */
    public function show(fixed_appointment $fixed_appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\fixed_appointment  $fixed_appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(fixed_appointment $fixed_appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\fixed_appointment  $fixed_appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, fixed_appointment $fixed_appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\fixed_appointment  $fixed_appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(fixed_appointment $fixed_appointment)
    {
        //
    }
}
