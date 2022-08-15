<?php

namespace App\Http\Controllers\Api;;

use App\Models\area_state;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=area_state::where('status', '1')->orderBy('state_id', 'asc')->get();
            return response()->json([
                'data' => $data
            ], 200);
       }catch(\Exception $e) {
        return $this->getExceptionResponse($e);
        }
    }
    public function get_state()
    { 
        try{
            $data=area_state::orderBy('state_id', 'desc')->paginate(5);
            return response()->json([
                'data' => $data
            ], 200); 
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }
    public function state_status_changes(Request $request){
        // return $request->user_id;
        try{
            $request -> validate([
                    'state_id' => 'required|integer'
                ]);
            $data= area_state::select('status')->where('state_id', $request->state_id)->first();
            if($data['status']=='1'){
                area_state::where('state_id', $request->state_id)->update(['status' =>'0']);
            }else{
                area_state::where('state_id',$request->state_id)->update(['status' =>'1']);
            }
            return response()->json([
                'message' => 'State Status Changes',
                'status'=> 200
            ]);

           
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
            'state_name' => 'required',
            'status' => 'required|boolean'                       
        ]);
        try{ 
            $state_data = new area_state([
            'state' => $request->state_name,
            'status' => $request->status
            ]);

        $state_data->save();  
        return response() -> json([
                'message' => 'state Created',
            ]);

        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
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
     * @param  \App\Models\area_state  $area_state
     * @return \Illuminate\Http\Response
     */
    public function show(area_state $area_state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\area_state  $area_state
     * @return \Illuminate\Http\Response
     */
    public function edit(area_state $area_state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\area_state  $area_state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, area_state $area_state)
    {
        //
    }
     public function state_Update(Request $request)
    {
         $request->validate([
            'state_name' => 'required',
            'status' => 'required|boolean',
            'state_id'=>'required'                       
        ]);

      try{
       area_state::where('state_id', $request->state_id)->update(['state' => $request->state_name,'status'=> $request->status]);
              return response()->json([
              'message' =>'data updated',
              'status'=>201
            ], 201);
        }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\area_state  $area_state
     * @return \Illuminate\Http\Response
     */
    public function destroy(area_state $area_state)
    {
        //
    }
    public function delete(Request $request)
    {
        try{
            area_state::where('state_id', $request['state_id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
