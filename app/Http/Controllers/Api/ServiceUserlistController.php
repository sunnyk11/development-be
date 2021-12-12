<?php

namespace App\Http\Controllers\Api;

use App\Models\service_userlist;
use App\Http\Controllers\Controller;
use App\Models\user_service_provider;
use App\Models\User_service_mapping;
use App\Models\ServiceUserReviews;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Image;

class ServiceUserlistController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            try{
                $user_db=service_userlist::select('user_id')->where('status', '1')->orderBy('id', 'desc')->first();
                if($user_db){
                    $user_id ='u'. number_format(str_replace("u","",$user_db['user_id'])+1);
                    
                    // user created 
                    $user_data = [
                        'user_id' =>$user_id,
                        'user_name' => $request['data']['user'],
                        'contact' => $request['data']['contact']
                    ];
                    
                    if(service_userlist::create($user_data)){
                        // user  multiple services
                        foreach ($request['data']['service'] as $key => $value) { 
                            $user_data_mapping = [
                                'user_id' =>$user_id,
                                'user_name' => $request['data']['user'],
                                'contact' => $request['data']['contact'],
                                'service_id' =>$value['service_id']
                            ];
                            User_service_mapping::create($user_data_mapping);
                        }
                        //  service provider entery 
                        $user_service_provider = [
                            'loc_area_id' => $request['data']['LocalArea'],
                            'user_id' => $user_id
                        ];
                        user_service_provider::create($user_service_provider);
                        return response() -> json([
                            'message' => 'User Successfully Created',
                        ]);
                    }
            }else{
                $user_id=
                // user created 
                $user_data = [
                    'user_id' =>$user_id,
                    'user_name' => $request['data']['user'],
                    'contact' => $request['data']['contact']
                ];
                
                if(service_userlist::create($user_data)){
                    // user  multiple services
                    foreach ($request['data']['service'] as $key => $value) { 
                        $user_data_mapping = [
                            'user_id' =>$user_id,
                            'service_id' =>$value['service_id']
                        ];
                        User_service_mapping::create($user_data_mapping);
                    }
                    //  service provider entery 
                    $user_service_provider = [
                        'loc_area_id' => $request['data']['LocalArea'],
                        'user_id' => $user_id
                    ];
                    user_service_provider::create($user_service_provider);
                    return response() -> json([
                        'message' => 'User Successfully Created',
                    ]);
            }
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
   }  


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\service_userlist  $service_userlist
     * @return \Illuminate\Http\Response
     */
    public function show(service_userlist $service_userlist)
    {
        try{
           $data = service_userlist::where(['status'=> '1'])->with('user_service','user_review','local_area_user')->orderby('id','desc')->get();
           return response()->json([
                'data' =>$data,
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
    
    public function user_details_byId(Request $request){
        try{
            $user_id = Auth::user()->id;
            $user_data = service_userlist::where(['status'=> '1','user_id'=>$request->user_id])->with('service')->first();
            $review_data = ServiceUserReviews::where(['status'=> '1','s_user_id'=>$request->user_id])->with('UserDetail')->get();
            $user_review =ServiceUserReviews::where(['status'=> '1','s_user_id'=>$request->user_id,'user_id'=>$user_id])->first();
            $avg_reviews =ServiceUserReviews::where(['status'=> '1','s_user_id'=>$request->user_id])->select('stars', DB::raw('count(*) as users'))->groupBy('stars')->get();
                return response()->json([
                    'user_data'    => $user_data,
                    'review_data'  => $review_data,
                    'user_review'  =>$user_review,
                    'avg_reviews'     => $avg_reviews, 
                ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }

    }
    public function search_data(Request $request){
        try{
            $data = service_userlist::where(['status'=> '1'])->with('user_service','user_review','local_area_user')->orderby('id','desc')->get();
              return response()->json([
                    'data' =>$data,
                ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }    

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\service_userlist  $service_userlist
     * @return \Illuminate\Http\Response
     */
    public function edit(service_userlist $service_userlist)
    {
        //
    }
    
    public function service_user_update(Request $request){
        try{
            $data1=$request->data;
            $id=$data1['id'];
            $user_id= $data1['user_id'];
            $data=service_userlist::find($id);
            $data->user_name=$data1['user'];
            $data->contact=$data1['contact'];
           if($data->save()){
                $service=$data1['service'];
                if(count($service)>0){
                    User_service_mapping::where('user_id',$user_id)->delete();
                    foreach ($service as $service_data) { 
                        $user_data_mapping = [
                            'user_id' =>$user_id,
                            'service_id' =>$service_data['service_id']
                        ];
                        $user_service_data=User_service_mapping::where(['user_id'=>$user_id,'service_id'=>$service_data['service_id'],'status'=>'1'])->get();
                        $count= count($user_service_data);
                        if($count==0){
                            User_service_mapping::create($user_data_mapping);
                        }
                    }
                }
                //  service provider updated 
                user_service_provider::where('user_id',$user_id)->update(['loc_area_id'=>$data1['LocalArea']]);
                
                return response()->json([
                    'message' => 'user details Updated',
                ], 201);
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\service_userlist  $service_userlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, service_userlist $service_userlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\service_userlist  $service_userlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(service_userlist $service_userlist)
    {
        //
    }
    
    public function delete(Request $request)
    {
        try{
            service_userlist::where('user_id', $request['user_id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
    
    public function sevice_user_get_id(Request $request)
    {
        try{
            $service_user = service_userlist::where('user_id',  $request['user_id'])->with('user_service','user_review','local_area_user')->first();
               return response()->json([
                    'data' => $service_user
                ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
