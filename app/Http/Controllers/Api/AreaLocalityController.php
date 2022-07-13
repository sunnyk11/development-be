<?php

namespace App\Http\Controllers\Api;

use App\Models\area_locality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaLocalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=area_locality::where('status', '1')->orderBy('locality_id', 'asc')->get();
            return response()->json([
                'data' => $data
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }
    
    public function get_locality_byid(Request $request) {
        try{
            $data = area_locality::where('district_id', $request->id)->where('status','1')->orderBy('locality', 'asc')->get();
           return response()->json([
               'data' =>$data,
           ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
   }
   
   public function search_locality(Request $request) {
    // return $request->value;
    try{
        $data=[];
        $locality=area_locality::where('locality', 'like',  "%" . $request->value . "%")->where('status','1')->orderBy('locality', 'asc')->limit(10)->get();
        // return $locality;
         array_push($data,$locality);
            return response()->json([
                'data' => $data
            ], 200);
       }catch(\Exception $e) {
        return $this->getExceptionResponse($e);
        }
}
    
    // public function get_areas(Request $request) {

    //     return $areas = DB::table('areas')->select('area','pincode','id')->get();
    // }

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
     * @param  \App\Models\area_locality  $area_locality
     * @return \Illuminate\Http\Response
     */
    public function show(area_locality $area_locality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\area_locality  $area_locality
     * @return \Illuminate\Http\Response
     */
    public function edit(area_locality $area_locality)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\area_locality  $area_locality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, area_locality $area_locality)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\area_locality  $area_locality
     * @return \Illuminate\Http\Response
     */
    public function destroy(area_locality $area_locality)
    {
        //
    }
}
