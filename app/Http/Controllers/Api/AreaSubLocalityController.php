<?php

namespace App\Http\Controllers\Api;

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
    public function create(Request $request)
    {
         $request->validate([
            'sub_locality' => 'required',
            'sub_locality' => 'required',
            'status' => 'required|boolean'                       
        ]);
        try{ 
            $locality_data = [
            'locality_id' => $request->locality_id,
            'sub_locality' => $request->sub_locality,
            'status' => $request->status,
            ];
        area_sub_locality:: create($locality_data);
        return response() -> json([
                'message' => 'Sub-Locality Created',
            ]);

        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        }
    }

      
   public function sub_locality_status_changes(Request $request){
        try{
            $request -> validate([
                    'sub_locality_id' => 'required|integer'
                ]);
            $data= area_sub_locality::select('status')->where('sub_locality_id', $request->sub_locality_id)->first();
            // return $data;
            if($data['status']=='1'){
                area_sub_locality::where('sub_locality_id', $request->sub_locality_id)->update(['status' =>'0']);
            }else{
             area_sub_locality::where('sub_locality_id',$request->sub_locality_id)->update(['status' =>'1']);
            }
            return response()->json([
                'message' => 'Sub-Locality Status Changes',
                'status'=> 200
            ]);

           
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
    public function search_sub_locality_id(Request $request) {
        try{
            $data = area_sub_locality::with('locality')->where('locality_id', $request->locality_id)->orderBy('sub_locality_id', 'desc')->paginate(7);
           return response()->json([
               'data' =>$data,
           ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
   }

    public function get_common_area_data(Request $request) {
        // return $request->value;
        try{
            $data=[];
            $locality=[];
            $locality=area_locality::where('locality', 'like',  "%" . $request->value . "%")->where('status','1')->orderBy('locality', 'asc')->limit(5)->get();
            // return $locality;
             array_push($data,$locality);
            $sub_locality=area_sub_locality::where('sub_locality', 'like', "%" . $request->value . "%")->where('status','1')->orderBy('sub_locality', 'asc')->limit(10)->get();
                array_push($data,$sub_locality);
                return response()->json([
                    'data' => $data
                ], 200);
           }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
            }
   }
   
   public function get_internal_user_locality(Request $request) {
    // return $request->value;
    try{
        $data=[];
        $locality=[];
        $data=area_locality::where('locality', 'like',  "%" . $request->value . "%")->where('status','1')->orderBy('locality', 'asc')->limit(10)->get();
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

    public function edit_sub_locality_id(Request $request){
        try{
            $data= area_sub_locality::with('locality')->where('sub_locality_id',$request['sub_locality_id'])->first();
               return response()->json([
                    'data' => $data
                ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
    public function sub_locality_update(Request $request)
    {
         $request->validate([
            'locality_id' => 'required',
            'sub_locality' => 'required',
            'sub_locality_id' => 'required',
            'status' => 'required|boolean'                      
        ]);

      try{
       area_sub_locality::where('sub_locality_id', $request->sub_locality_id)->update(['locality_id' => $request->locality_id,'status'=> $request->status,'sub_locality'=> $request->sub_locality]);
              return response()->json([
              'message' =>'data updated',
              'status'=>201
            ], 201);
        }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
    }

    public function delete(Request $request)
    {
        try{
            area_sub_locality::where('sub_locality_id', $request['sub_locality_id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
