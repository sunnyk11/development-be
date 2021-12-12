<?php

namespace App\Http\Controllers\Api;

use App\Models\AreaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User_service_mapping;
use App\Models\service_userlist;
use App\Models\user_service_provider;

class AreaServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=AreaService::where('status', '1')->orderBy('id', 'desc')->get();
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
        try{
            $service_db=AreaService::select('service_id')->where('status', '1')->orderBy('id', 'desc')->first();
            if($service_db){
                $service_id = number_format(str_replace("S","",$service_db['service_id'])+1);
                $service_data = [
                'service_id' =>'S'.$service_id,
                'service_name' => $request['data']['service']
                ];
               
            AreaService::create($service_data);
            return response() -> json([
                'message' => 'Services Created',
            ]);
            }else{
            $service_id='S01';
                $service_data = [
                'service_id' =>$service_id,
                'service_name' => $request['data']['service']
            ];
            AreaService::create($service_data);
            return response() -> json([
                'message' => 'Services Created',
            ]);
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }
    public function update_service_id(Request $request){
        try{
            $service= AreaService::where('id',  $request['service_id'])->first();
               return response()->json([
                    'data' => $service
                ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }

    }
    
    public function service_update(Request $request){
        // return $request->all();
        try{
            $data1=$request->data;
            $id=$data1['id'];
            $service_id= $data1['service_id'];
            $data=AreaService::find($id);
            $data->service_name=$data1['service'];            
            if($data->save()){
                return response()->json([
                    'message' => 'Service details Updated',
                ], 201);
            }
            

        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }
    public function get_service_By_id(Request $request) {
        try{
            $LocalArea = user_service_provider::where('loc_area_id', $request->id)->get();
            $LocalAreaId=json_decode(json_encode($LocalArea), true);
            $length=count($LocalAreaId);
            $array=[]; 
            for($i=0; $i<$length; $i++){
                array_push($array,$LocalAreaId[$i]['user_id']);
            }
            $service = User_service_mapping::select('service_id')->whereIn('user_id',$array)->get();
            $service_data = AreaService::whereIn('service_id',$service)->groupBy('service_name')->havingRaw('COUNT(*) > 0')->get();      
            return response()->json([
                'data' =>$service_data,
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }   
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
    
    public function delete(Request $request)
    {
        try{
            AreaService::where('service_id', $request['service_id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
