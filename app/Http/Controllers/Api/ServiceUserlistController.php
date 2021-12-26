<?php

namespace App\Http\Controllers\Api;

use App\Models\service_userlist;
use App\Http\Controllers\Controller;
use App\Models\user_area_mapping;
use App\Models\state_district_mapping;
use App\Models\User_service_mapping;
use App\Models\district_locality_mapping;
use App\Models\locality_sublocality_mapping;
use App\Models\backend_reviews_user;
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
                    // return $user_data;
                    
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
                            'state_id' => $request['data']['city'],
                            'user_id' => $user_id
                        ];
                       $user_area= user_area_mapping::create($user_service_provider);
                        if($user_area->id && $request['data']['district']){
                            //  service provider entery 
                            $user_district_mapping = [
                                'state_id' => $user_area->id,
                                'district_id' => $request['data']['district'],
                                'user_id' =>$user_id
                            ];
                            $user_district= state_district_mapping::create($user_district_mapping);
                            if($user_district->id &&  $request['data']['locality']){
                               $user_locality_mapping = [
                                    'district_id' => $user_district->id,
                                    'locality_id' => $request['data']['locality'],
                                    'user_id' =>$user_id
                                ];
                               $user_locality=district_locality_mapping::create($user_locality_mapping);
                               if($user_locality->id && $request['data']['sub_locality']){
                                    foreach ($request['data']['sub_locality'] as $key => $sub_locality) { 
                                        $user_sub_locality_mapping = [
                                            'locality_id' => $user_locality->id,
                                            'sub_locality_id' => $sub_locality['sub_locality_id'],
                                            'user_id' =>$user_id
                                        ];
                                        locality_sublocality_mapping::create($user_sub_locality_mapping);
                                    }
                               }
                           }
                        }
                        return response() -> json([
                            'message' => 'User Successfully Created',
                        ]);
                    }
            }else{
                $user_id='u1'; 
                // user created 
                $user_data = [
                    'user_id' =>$user_id,
                    'user_name' => $request['data']['user'],
                    'contact' => $request['data']['contact']
                ];
                // return $user_data;
                
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
                        'state_id' => $request['data']['city'],
                        'user_id' => $user_id
                    ];
                    $user_area= user_area_mapping::create($user_service_provider);
                    if($user_area->id && $request['data']['district']){
                        //  service provider entery 
                        $user_district_mapping = [
                            'state_id' => $user_area->id,
                            'district_id' => $request['data']['district'],
                            'user_id' =>$user_id
                        ];
                        $user_district= state_district_mapping::create($user_district_mapping);
                        if($user_district->id &&  $request['data']['locality']){
                            $user_locality_mapping = [
                                'district_id' => $user_district->id,
                                'locality_id' => $request['data']['locality'],
                                'user_id' =>$user_id
                            ];
                            $user_locality=district_locality_mapping::create($user_locality_mapping);
                            if($user_locality->id && $request['data']['sub_locality']){
                                foreach ($request['data']['sub_locality'] as $key => $sub_locality) { 
                                    $user_sub_locality_mapping = [
                                        'locality_id' => $user_locality->id,
                                        'sub_locality_id' => $sub_locality['sub_locality_id'],
                                        'user_id' =>$user_id
                                    ];
                                    locality_sublocality_mapping::create($user_sub_locality_mapping);
                                }
                            }
                        }
                    }
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
           $data = service_userlist::where(['status'=> '1'])->with('user_service','user_review','user_area')->orderby('id','desc')->get();
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
            $user_data = service_userlist::where(['status'=> '1','user_id'=>$request->input('user_id')])->with('service')->first();
            $review_data = backend_reviews_user::where(['status'=> '1','s_user_id'=>$request->input('user_id')])->with('UserDetail')->get();
            $user_review =backend_reviews_user::where(['status'=> '1','s_user_id'=>$request->input('user_id'),'user_id'=>$user_id])->first();
            $avg_reviews =backend_reviews_user::where(['status'=> '1','s_user_id'=>$request->input('user_id')])->select('stars', DB::raw('count(*) as users'))->groupBy('stars')->get();
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
        // return $request->all();
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
                // city updated 
                 $city=$data1['city'];
                if($city){
                    user_area_mapping::where(['state_id'=>$city,'user_id'=>$user_id])->delete();
                        $user_city_mapping = [
                            'state_id' =>$city,
                            'user_id' =>$user_id
                        ];
                        $user_city_data=user_area_mapping::where(['user_id'=>$user_id,'state_id'=>$city,'status'=>'1'])->get();
                        $city_count= count($user_city_data);
                        // return $count;
                        if($city_count==0){
                            $user_area= user_area_mapping::create($user_city_mapping);
                        }
                }
                // district updated 
                $district=$data1['district'];
                if($district){
                    state_district_mapping::where(['district_id'=>$district,'user_id'=>$user_id])->delete();
                    $user_district_mapping = [
                        'state_id' =>$user_area->id,
                        'user_id' =>$user_id,
                        'district_id' =>$district
                    ];
                    // return $user_district_mapping;
                    $user_district_data=state_district_mapping::where(['user_id'=>$user_id,'district_id'=>$district,'status'=>'1'])->get();
                    $district_count= count($user_district_data);
                    if($district_count==0){
                       $user_district=state_district_mapping::create($user_district_mapping);
                    }
                }
                // locality updated 
                $locality=$data1['locality'];
                if($locality){
                    district_locality_mapping::where(['locality_id'=>$locality,'user_id'=>$user_id])->delete();
                    $user_locality_mapping = [
                        'district_id' =>$user_district->id,
                        'user_id' =>$user_id,
                        'locality_id' =>$locality
                    ]; 
                    $user_locality_data=district_locality_mapping::where(['user_id'=>$user_id,'locality_id'=>$locality,'status'=>'1'])->get();
                    $locality_count= count($user_locality_data);
                    if($district_count==0){
                       $user_locality=district_locality_mapping::create($user_locality_mapping);
                    }
                }
                // sublocality data updated 
               $sub_locality=$data1['sub_locality'];
               if(count($sub_locality)>0){
                    locality_sublocality_mapping::where('user_id',$user_id)->delete();
                    foreach ($sub_locality as $sub_locality_data) { 
                        $user_sub_locality_mapping = [
                            'locality_id' =>$user_locality->id,
                            'user_id' =>$user_id,
                            'sub_locality_id' =>$sub_locality_data['sub_locality_id']
                        ];

                        $user_sublocality_data=locality_sublocality_mapping::where(['user_id'=>$user_id,'sub_locality_id'=>$sub_locality_data['sub_locality_id'],'status'=>'1'])->get();
                        $sublocality_count= count($user_sublocality_data);
                        if($sublocality_count==0){
                            locality_sublocality_mapping::create($user_sub_locality_mapping);
                        }
                    }
                } 
                return response()->json([
                    'message' => 'user details Updated',
                ], 201);
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }
    
    public function star_ratingbyId(Request $request){

        $rating_data = backend_reviews_user::where(['status'=> '1','s_user_id'=>$request->service_id,'stars'=>$request->star])->with('UserDetail')->get();
        return response()->json([
           'rating_data'  => $rating_data, 
         ], 201);
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
            service_userlist::where('id', $request['id'])->delete();  
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
    
    public function update_service_userById(Request $request)
    {
        try{
            $service_user = service_userlist::where('id',  $request['user_id'])->with('user_service','user_state','user_district','user_locality','user_sublocality')->first();
               return response()->json([
                    'data' => $service_user
                ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
