<?php

namespace App\Http\Controllers\Api;

use App\Models\AreaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\AreaServiceUser;

class AreaServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=AreaService::select('service_id','service_name')->where('status', '1')->orderBy('id', 'desc')->get();
        return response()->json([
            'data' => $data
        ], 200);    }

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
    public function get_service_By_id(Request $request) {
      $LocalArea = ServiceProvider::where('loc_area_id', $request->id)->get();
        $LocalAreaId=json_decode(json_encode($LocalArea), true);
         $length=count($LocalAreaId);
          $array=[]; 
        for($i=0; $i<$length; $i++){
            array_push($array,$LocalAreaId[$i]['user_id']);
        }
        $service = AreaServiceUser::select('service_id')->whereIn('user_id',$array)->get();
        $service_data = AreaService::whereIn('service_id',$service)->groupBy('service_name')->havingRaw('COUNT(*) > 0')->get();      
        return response()->json([
            'data' =>$service_data,
        ], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AreaService  $areaService
     * @return \Illuminate\Http\Response
     */
    public function show(AreaService $areaService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaService  $areaService
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaService $areaService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaService  $areaService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AreaService $areaService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaService  $areaService
     * @return \Illuminate\Http\Response
     */
    public function destroy(AreaService $areaService)
    {
        //
    }
}
