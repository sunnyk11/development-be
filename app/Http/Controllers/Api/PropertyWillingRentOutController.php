<?php

namespace App\Http\Controllers\Api;

use App\Models\property_willing_rent_out;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class PropertyWillingRentOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=property_willing_rent_out::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
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
     * @param  \App\Models\property_willing_rent_out  $property_willing_rent_out
     * @return \Illuminate\Http\Response
     */
    public function show(property_willing_rent_out $property_willing_rent_out)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\property_willing_rent_out  $property_willing_rent_out
     * @return \Illuminate\Http\Response
     */
    public function edit(property_willing_rent_out $property_willing_rent_out)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\property_willing_rent_out  $property_willing_rent_out
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, property_willing_rent_out $property_willing_rent_out)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\property_willing_rent_out  $property_willing_rent_out
     * @return \Illuminate\Http\Response
     */
    public function destroy(property_willing_rent_out $property_willing_rent_out)
    {
        //
    }
}
