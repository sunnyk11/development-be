<?php

namespace App\Http\Controllers\Api;

use App\Models\property_maintenance_condition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class PropertyMaintenanceConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=property_maintenance_condition::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
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
     * @param  \App\Models\property_maintenance_condition  $property_maintenance_condition
     * @return \Illuminate\Http\Response
     */
    public function show(property_maintenance_condition $property_maintenance_condition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\property_maintenance_condition  $property_maintenance_condition
     * @return \Illuminate\Http\Response
     */
    public function edit(property_maintenance_condition $property_maintenance_condition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\property_maintenance_condition  $property_maintenance_condition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, property_maintenance_condition $property_maintenance_condition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\property_maintenance_condition  $property_maintenance_condition
     * @return \Illuminate\Http\Response
     */
    public function destroy(property_maintenance_condition $property_maintenance_condition)
    {
        //
    }
}
