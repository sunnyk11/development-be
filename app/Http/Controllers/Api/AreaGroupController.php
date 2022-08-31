<?php

namespace App\Http\Controllers\Api;

use App\Models\area_group;
use App\Models\area_group_pivot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AreaGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=area_group::orderBy('id', 'asc')->with('pivot_data')->paginate(8);
            return response()->json([
                'data' => $data
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }
    public function get_group_details_id(Request $request){
        try{
            $data= area_group::with('pivot_data')->where('id', $request['group_id'])->first();
               return response()->json([
                    'data' => $data
                ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    public function area_group_update(Request $request)
    {
        // return $request->all();
         $request->validate([
            'group_id' => 'required',   
            'group_name' => 'required'               
        ]);

      try{
      $update_data= area_group::where('id', $request->group_id)->update(['group_name' => $request->group_name,'created_user'=>Auth::user()->id]);
      if($update_data){        
            area_group_pivot::where('group_id', $request->group_id)->delete();
             foreach ($request['sub_locality'] as $key => $value) {
            $pivot_data=[
                        'group_id' =>$request->group_id,
                        'sub_locality_id' => $value['sub_locality_id']
                    ];
            area_group_pivot::create($pivot_data);
           }
            return response()->json([
                    'message' => 'Group Update',
                    'status'=>201
            ], 201);

      }else{
        return response()->json([
              'message' =>'Group Not updated',
              'status'=>404
            ], 201);
      }
        $new_data=area_locality::select('locality_id','locality','district_id','status')->where('locality_id', $request->locality_id)->first();
          if($old_data){
                 $transaction_data=[
                    'table_name'=>'area_localities',
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // return $request->all();
         $request->validate([
            'group_name' => 'required'  
        ]);

        try{ 
         $group_data=[
            'group_name'=>$request->group_name,
            'created_user'=> Auth::user()->id
         ];
         $areagroup_db=area_group::create($group_data);
         // return $areagroup_db['id'];
           foreach ($request['sub_locality'] as $key => $value) {
            $pivot_data=[
                        'group_id' =>$areagroup_db['id'],
                        'sub_locality_id' => $value['sub_locality_id']
                    ];
            area_group_pivot::create($pivot_data);
           }
            return response()->json([
                    'message' => 'Group Created',
                    'status'=>201
            ], 201);
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
     * @param  \App\Models\area_group  $area_group
     * @return \Illuminate\Http\Response
     */
    public function show(area_group $area_group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\area_group  $area_group
     * @return \Illuminate\Http\Response
     */
    public function edit(area_group $area_group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\area_group  $area_group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, area_group $area_group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\area_group  $area_group
     * @return \Illuminate\Http\Response
     */
    public function destroy(area_group $area_group)
    {
        //
    }
      public function delete(Request $request)
    {
        try{  
            area_group::where('id', $request['group_id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
