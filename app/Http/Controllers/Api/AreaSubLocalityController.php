<?php

namespace App\Http\Controllers\Api;

use App\Models\area_sub_locality;
use App\Models\area_locality;
use Illuminate\Http\Request;
use App\Models\area_transaction;
use Auth;
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
         $create_data=area_sub_locality::select('sub_locality_id','sub_locality','locality_id','status')->where('status', '1')->orderBy('sub_locality_id', 'desc')->first();
         if($create_data){
             $transaction_data=[
                'table_name'=>'area_sub_localities',
                'old_column'=> NULL,
                'new_column'=>json_encode($create_data),
                'action'=>'Create',
                'updated_user'=> Auth::user()->id
             ];
             area_transaction::create($transaction_data);
            
            return response() -> json([
                    'message' => 'Sub-Locality Created',
                ]);
        }

        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        }
    }

      
   public function sub_locality_status_changes(Request $request){
        try{
            $request -> validate([
                    'sub_locality_id' => 'required|integer'
                ]);
            $data= area_sub_locality::select('sub_locality_id','sub_locality','locality_id','status')->where('sub_locality_id', $request->sub_locality_id)->first();
            // return $data;
            if($data['status']=='1'){
                area_sub_locality::where('sub_locality_id', $request->sub_locality_id)->update(['status' =>'0']);
            }else{
             area_sub_locality::where('sub_locality_id',$request->sub_locality_id)->update(['status' =>'1']);
            }
             $new_data= area_sub_locality::select('sub_locality_id','sub_locality','locality_id','status')->where('sub_locality_id', $request->sub_locality_id)->first();
              $transaction_data=[
                    'table_name'=>'area_sub_localities',
                    'old_column'=> json_encode($data),
                    'new_column'=>json_encode($new_data),
                    'action'=>'Status Update',
                    'updated_user'=> Auth::user()->id
                 ];
                 area_transaction::create($transaction_data);
            return response()->json([
                'message' => 'Sub-Locality Status Changes',
                'status'=> 200
            ]);

           
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

   public function crm_sub_localityby_localityid(Request $request) {
     $request->validate([
                'locality_id' => 'required',
            ]);
    try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                    $locality = area_sub_locality::where('locality_id', $request->locality_id)->where('status','1')->orderBy('sub_locality_id','asc')->get();
                    if(count($locality)>0){
                    return response()->json([
                        'data' => $locality,
                        'status'=>200
                    ], 200);                        
                    }else{
                    return response()->json([
                         'message' =>'FAIL',
                         'description' => 'Locality Id is Invalid !!!',
                         'status'=>200
                     ], 200);

                    }
                
              }else{
                return response() -> json([
                    'message' => 'Failure',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            }   
               
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

 public function get_sub_locality_searching(Request $request) {
    try{
        if($request->search_locality_id){
           $data=area_sub_locality::where('sub_locality', 'like',  "%" . $request->value . "%")->with('locality')->where('locality_id', $request->search_locality_id)->where('status','1')->orderBy('sub_locality_id', 'asc')->paginate(7);
            return response()->json([
                'data' => $data
            ], 200); 
        }else{
            $data=area_sub_locality::where('sub_locality', 'like',  "%" . $request->value . "%")->with('locality')->where('status','1')->orderBy('sub_locality_id', 'asc')->paginate(7);
            return response()->json([
                'data' => $data
            ], 200);
        }
        
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
        $old_data=area_sub_locality::select('sub_locality_id','sub_locality','locality_id','status')->where('sub_locality_id', $request->sub_locality_id)->first();
       area_sub_locality::where('sub_locality_id', $request->sub_locality_id)->update(['locality_id' => $request->locality_id,'status'=> $request->status,'sub_locality'=> $request->sub_locality]);
         $new_data=area_sub_locality::select('sub_locality_id','sub_locality','locality_id','status')->where('sub_locality_id', $request->sub_locality_id)->first();

             if($old_data){
                 $transaction_data=[
                    'table_name'=>'area_sub_localities',
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

    public function delete(Request $request)
    {
        try{
             $data=area_sub_locality::select('sub_locality_id','sub_locality','locality_id','status')->where('sub_locality_id', $request['sub_locality_id'])->first();
             if($data){
                 $transaction_data=[
                    'table_name'=>'area_sub_localities',
                    'old_column'=> json_encode($data),
                    'new_column'=>NULL,
                    'action'=>'Delete',
                    'updated_user'=> Auth::user()->id
                 ];
                 area_transaction::create($transaction_data);
                 area_sub_locality::where('sub_locality_id', $request['sub_locality_id'])->delete();  
                return response()->json([
                    'message' => 'deleted Successfully',
                ], 201);

             }
           
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
