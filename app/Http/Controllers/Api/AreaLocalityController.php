<?php

namespace App\Http\Controllers\Api;

use App\Models\area_locality;
use Illuminate\Http\Request;
use App\Models\area_transaction;
use Auth;
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

    public function search_locality_id(Request $request) {
        try{
            $data = area_locality::with('district')->where('district_id', $request->district_id)->orderBy('locality_id', 'desc')->paginate(7);
           return response()->json([
               'data' =>$data,
           ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
   }
   public function locality_status_changes(Request $request){
        try{
            $request -> validate([
                    'locality_id' => 'required|integer'
                ]);
            $data= area_locality::select('locality_id','locality','district_id','status')->where('locality_id', $request->locality_id)->first();
            // return $data;
            if($data['status']=='1'){
                area_locality::where('locality_id', $request->locality_id)->update(['status' =>'0']);
            }else{
             area_locality::where('locality_id',$request->locality_id)->update(['status' =>'1']);
            }
            $new_data=area_locality::select('locality_id','locality','district_id','status')->where('locality_id', $request->locality_id)->first();
                 $transaction_data=[
                    'table_name'=>'area_localities',
                    'old_column'=> json_encode($data),
                    'new_column'=>json_encode($new_data),
                    'action'=>'Status Update',
                    'updated_user'=> Auth::user()->id
                 ];
                 area_transaction::create($transaction_data);
            return response()->json([
                'message' => 'Locality Status Changes',
                'status'=> 200
            ]);

           
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

   
   public function search_locality(Request $request) {
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

   public function crm_search_locality(Request $request) {
     $request->validate([
                'search_keyword' => 'required',
            ]);
    try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                if(Strlen($request->search_keyword)>2){
                     $locality=area_locality::where('locality', 'like',  "%" . $request->search_keyword . "%")->where('status','1')->orderBy('locality', 'asc')->limit(10)->get();
                    return response()->json([
                        'data' => $locality,
                        'status'=>200
                    ], 200);
                }else{
                    return response()->json([
                         'message' =>'FAIL',
                         'description' => 'Search keyword Length Mini 3',
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
    
   public function crm_locality_id(Request $request) {
     $request->validate([
                'locality_id' => 'required',
            ]);
    try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                     $locality=area_locality::select('locality_id','locality','district_id','status')->where(['locality_id'=> $request->locality_id,'status'=> '1'])->first();
                     if($locality){
                        return response()->json([
                            'data' => $locality,
                            'status'=>200
                        ], 200);
                     }else{
                        return response()->json([
                            'message' =>'FAIL',
                         'description' => 'Locality Id is Invalid !!!...',
                         'status'=>200
                     ],200);
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
    

   public function search_locality1(Request $request) {
    try{
        $data=area_locality::where('locality', 'like',  "%" . $request->value . "%")->where('district_id', $request->district_id)->where('status','1')->orderBy('locality_id', 'asc')->get();
            return response()->json([
                'data' => $data
            ], 200);
       }catch(\Exception $e) {
        return $this->getExceptionResponse($e);
        }
    }
     public function get_locality_searching(Request $request) {
    try{
        if($request->search_district_id){
        $data=area_locality::where('locality', 'like',  "%" . $request->value . "%")->with('district')->where('district_id', $request->search_district_id)->orderBy('locality_id', 'asc')->paginate(7);
            return response()->json([
                'data' => $data
            ], 200);

        }else{

        $data=area_locality::where('locality', 'like',  "%" . $request->value . "%")->with('district')->where('status','1')->orderBy('locality_id', 'asc')->paginate(7);
            return response()->json([
                'data' => $data
            ], 200);
        }
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
   public function create(Request $request)
    {
         $request->validate([
            'district_id' => 'required',
            'locality' => 'required',
            'status' => 'required|boolean'                       
        ]);
        try{ 
            $locality_data = [
            'district_id' => $request->district_id,
            'locality' => $request->locality,
            'status' => $request->status,
            ];
        area_locality:: create($locality_data);
       $create_data=area_locality::select('locality_id','locality','district_id','status')->where('status', '1')->orderBy('locality_id', 'desc')->first();
         if($create_data){
             $transaction_data=[
                'table_name'=>'area_localities',
                'old_column'=> NULL,
                'new_column'=>json_encode($create_data),
                'action'=>'Create',
                'updated_user'=> Auth::user()->id
             ];
             area_transaction::create($transaction_data);
            return response() -> json([
                    'message' => 'Locality Created',
                ]);
       }

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
    public function edit_locality_id(Request $request){
        try{
            $data= area_locality::with('district')->where('locality_id',$request['locality_id'])->first();
               return response()->json([
                    'data' => $data
                ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    public function locality_update(Request $request)
    {
         $request->validate([
            'district_id' => 'required',
            'locality' => 'required',
            'locality_id' => 'required',
            'status' => 'required|boolean'                      
        ]);

      try{
        $old_data=area_locality::select('locality_id','locality','district_id','status')->where('locality_id', $request->locality_id)->first(); 
       area_locality::where('locality_id', $request->locality_id)->update(['district_id' => $request->district_id,'status'=> $request->status,'locality'=> $request->locality]);

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

    public function delete(Request $request)
    {
        try{

             $data=area_locality::select('locality_id','locality','district_id','status')->where('locality_id', $request['locality_id'])->first();
             if($data){
                 $transaction_data=[
                    'table_name'=>'area_localities',
                    'old_column'=> json_encode($data),
                    'new_column'=>NULL,
                    'action'=>'Delete',
                    'updated_user'=> Auth::user()->id
                 ];
                 area_transaction::create($transaction_data);
               
            area_locality::where('locality_id', $request['locality_id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);

             }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
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
