<?php

namespace App\Http\Controllers\Api;

use App\Models\area_district;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaDistrictController extends Controller
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
    public function get_district_byid(Request $request) {
        try{
            $data = area_district::where('state_id', $request->id)->orderBy('district', 'asc')->get();
           return response()->json([
               'data' =>$data,
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
     * @param  \App\Models\area_district  $area_district
     * @return \Illuminate\Http\Response
     */
    public function show(area_district $area_district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\area_district  $area_district
     * @return \Illuminate\Http\Response
     */
    public function edit(area_district $area_district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\area_district  $area_district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, area_district $area_district)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\area_district  $area_district
     * @return \Illuminate\Http\Response
     */
    public function destroy(area_district $area_district)
    {
        //
    }
}
