<?php

namespace App\Http\Controllers\Api;

use App\Models\property_ageement_duration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class PropertyAgeementDurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        try{
            $data=property_ageement_duration::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
            return response()->json([
                'data' => $data
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\property_ageement_duration  $property_ageement_duration
     * @return \Illuminate\Http\Response
     */
    public function show(property_ageement_duration $property_ageement_duration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\property_ageement_duration  $property_ageement_duration
     * @return \Illuminate\Http\Response
     */
    public function edit(property_ageement_duration $property_ageement_duration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\property_ageement_duration  $property_ageement_duration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, property_ageement_duration $property_ageement_duration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\property_ageement_duration  $property_ageement_duration
     * @return \Illuminate\Http\Response
     */
    public function destroy(property_ageement_duration $property_ageement_duration)
    {
        //
    }
}
