<?php

namespace App\Http\Controllers\Api;

use App\Models\area_district;
use Illuminate\Http\Request;
use App\Models\area_transaction;
use Auth;
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
     public function get_district()
    { 
        try{
            $data=area_district::with('state')->orderBy('district_id', 'desc')->paginate(5);
            return response()->json([
                'data' => $data
            ], 200); 
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }
    public function get_district_byid(Request $request) {
        try{
            $data = area_district::where('state_id', $request->id)->where('status','1')->orderBy('district', 'asc')->get();
           return response()->json([
               'data' =>$data,
           ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
   }
   public function search_district_id(Request $request) {
        try{
            $data = area_district::with('state')->where('state_id', $request->state_id)->orderBy('district_id', 'desc')->paginate(7);
           return response()->json([
               'data' =>$data,
           ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
   }
   public function search_district(Request $request){
        try{
        $data=area_district::where('district', 'like',  "%" .Strtoupper($request->value) . "%")->where('state_id', $request->state_id)->orderBy('district_id', 'asc')->get();
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
    public function create(Request $request)
    {
         $request->validate([
            'district' => 'required',
            'state' => 'required',
            'status' => 'required|boolean'                       
        ]);
        try{ 
            $district_data = [
            'district' => $request->district,
            'state_id' => $request->state,
            'status' => $request->status,
            ];
        area_district:: create($district_data);
        $create_data=area_district::select('state_id','district_id','district','status')->where('status', '1')->orderBy('district_id', 'desc')->first();
         if($create_data){
         $transaction_data=[
            'table_name'=>'area_districts',
            'old_column'=> NULL,
            'new_column'=>json_encode($create_data),
            'action'=>'Create',
            'updated_user'=> Auth::user()->id
         ];
         area_transaction::create($transaction_data);
        return response() -> json([
                'message' => 'district Created',
            ]);
      }

        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        }
    }
    public function district_update(Request $request)
    {
         $request->validate([
            'district' => 'required',
            'status' => 'required|boolean',
            'state'=>'required',
            'district_id' =>'required'                     
        ]);

      try{
        $old_data=area_district::select('state_id','district_id','district','status')->where('district_id', $request->district_id)->first();
       area_district::where('district_id', $request->district_id)->update(['state_id' => $request->state,'status'=> $request->status,'district'=> $request->district]);
         $new_data=area_district::select('state_id','district_id','district','status')->where('district_id', $request->district_id)->first();

             if($old_data){
                 $transaction_data=[
                    'table_name'=>'area_districts',
                    'old_column'=> json_encode($old_data),
                    'new_column'=>json_encode($new_data),
                    'action'=>'Update',
                    'updated_user'=> Auth::user()->id
                 ];
                 area_transaction::create($transaction_data);
              return response()->json([
              'message' =>'data updated',
              'status'=>201
            ], 201); 
             }
        }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
    }

    public function district_status_changes(Request $request){
         try{
            $request -> validate([
                    'district_id' => 'required|integer'
                ]);
            $data= area_district::select('state_id','district','district_id','status')->where('district_id', $request->district_id)->first();
            // return $data;
            if($data['status']=='1'){
                area_district::where('district_id', $request->district_id)->update(['status' =>'0']);
            }else{
             area_district::where('district_id',$request->district_id)->update(['status' =>'1']);
            }
            $new_data=area_district::select('state_id','district','district_id','status')->where('district_id', $request['district_id'])->first();
                 $transaction_data=[
                    'table_name'=>'area_districts',
                    'old_column'=> json_encode($data),
                    'new_column'=>json_encode($new_data),
                    'action'=>'Status Update',
                    'updated_user'=> Auth::user()->id
                 ];
                 area_transaction::create($transaction_data);
            return response()->json([
                'message' => 'District Status Changes',
                'status'=> 200
            ]);

           
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
    public function delete(Request $request)
    {
        try{
            $data=area_district::where('district_id', $request['district_id'])->first();
             if($data){
                 $transaction_data=[
                    'table_name'=>'area_districts',
                    'old_column'=> json_encode($data),
                    'new_column'=>NULL,
                    'action'=>'Delete',
                    'updated_user'=> Auth::user()->id
                 ];
                 area_transaction::create($transaction_data);
                
            area_district::where('district_id', $request['district_id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);
             }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
