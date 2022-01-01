<?php

namespace App\Http\Controllers\Api;;

use App\Models\area_sub_locality;
use App\Models\area_locality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaSubLocalityController extends Controller
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
    
    public function get_common_area_data(Request $request) {
        // return $request->value;
        try{
            $data=[];
            $locality=[];
            $locality=area_locality::where('locality', 'like',  "%" . $request->value . "%")->orderBy('locality', 'asc')->limit(5)->get();
            // return $locality;
             array_push($data,$locality);
            $sub_locality=area_sub_locality::where('sub_locality', 'like', "%" . $request->value . "%")->orderBy('sub_locality', 'asc')->limit(10)->get();
                array_push($data,$sub_locality);
                return response()->json([
                    'data' => $data
                ], 200);
           }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
            }
   }

    
    public function sub_localitybyid(Request $request) {
       try{
        $district=area_locality::where(['status'=> '1','locality_id'=>$request->Locality_id])->orderBy('locality_id', 'asc')->with('district')->first();
        $data=area_sub_locality::where(['status'=> '1','locality_id'=>$request->Locality_id])->orderBy('locality_id', 'asc')->get();
        return response()->json([
            'data' => $data,
            'district'=>$district
        ], 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\area_sub_locality  $area_sub_locality
     * @return \Illuminate\Http\Response
     */
    public function show(area_sub_locality $area_sub_locality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\area_sub_locality  $area_sub_locality
     * @return \Illuminate\Http\Response
     */
    public function edit(area_sub_locality $area_sub_locality)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\area_sub_locality  $area_sub_locality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, area_sub_locality $area_sub_locality)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\area_sub_locality  $area_sub_locality
     * @return \Illuminate\Http\Response
     */
    public function destroy(area_sub_locality $area_sub_locality)
    {
        //
    }
}