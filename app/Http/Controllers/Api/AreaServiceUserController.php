<?php

namespace App\Http\Controllers\Api;

use App\Models\AreaServiceUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\ServiceUserReviews;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AreaServiceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_data=AreaServiceUser::groupBy('user_name')->where('status', '1')->with('user_service')->orderBy('id', 'desc')->get();
        $grouped = $user_data->groupBy('user_name')->map(function ($row) {return $row->count();});
        return $user_data;
        return response()->json([
            'data' => $data
        ], 200);
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
        $user_db=AreaServiceUser::select('user_id')->where('status', '1')->orderBy('id', 'desc')->first();
         if($user_db){
            // user entery multiple services
            foreach ($request['data']['service'] as $key => $value) {
                $user_db=AreaServiceUser::select('user_id')->where('status', '1')->orderBy('id', 'desc')->first();
                $user_id = number_format(str_replace("u","",$user_db['user_id'])+1);
                    $user_data = [
                        'user_id' =>'u'.$user_id,
                        'user_name' => $request['data']['user'],
                        'contact' => $request['data']['contact'],
                        'service_id' =>$value['service_id']
                    ];
                    // return $user_data;
                AreaServiceUser::create($user_data);
            }
            
            //  service provider entery 
            $user_db_provider=AreaServiceUser::select('user_id')->where('status', '1')->orderBy('id', 'desc')->first();
            $user_id_provider = number_format(str_replace("u","",$user_db_provider['user_id']));
            $user_service_provider = [
                'loc_area_id' => $request['data']['LocalArea'],
                'user_id' => 'u'.$user_id_provider
            ];
            ServiceProvider::create($user_service_provider);
            //  service provider entery 

            return response() -> json([
                'message' => 'User Successfully Created',
            ]);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AreaServiceUser  $areaServiceUser
     * @return \Illuminate\Http\Response
     */
    public function show(AreaServiceUser $areaServiceUser)
    {
        //
    }
    public function search_data(Request $request){
        // return $request->all();
       $data = AreaServiceUser::where(['status'=> '1'])->with('service','user_review')->search($request)->orderby('id','desc')->get();
       // return $data[0]['user_review'][1];
        return response()->json([
            'data' =>$data,
          ], 201);

    }
    public function star_ratingbyId(Request $request){

         $rating_data = ServiceUserReviews::where(['status'=> '1','s_user_id'=>$request->service_id,'stars'=>$request->star])->with('UserDetail','service_img')->get();
         return response()->json([
            'rating_data'  => $rating_data, 
          ], 201);
   }
    public function user_details_byId(Request $request){
        // user details by id
       $user_id = Auth::user()->id;
       $user_data = AreaServiceUser::where(['status'=> '1','user_id'=>$request->user_id])->with('service')->first();
       // user review by id
       $review_data = ServiceUserReviews::where(['status'=> '1','s_user_id'=>$request->user_id])->with('UserDetail')->get();

       $user_review =ServiceUserReviews::where(['status'=> '1','s_user_id'=>$request->user_id,'user_id'=>$user_id])->first();
        
        $avg_reviews =ServiceUserReviews::where(['status'=> '1','s_user_id'=>$request->user_id])->select('stars', DB::raw('count(*) as users'))->groupBy('stars')->get();
        

        return response()->json([
            'user_data'    => $user_data,
            'review_data'  => $review_data,
            'user_review'  =>$user_review,
            'avg_reviews'     => $avg_reviews, 
          ], 201);

    }


   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaServiceUser  $areaServiceUser
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaServiceUser $areaServiceUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaServiceUser  $areaServiceUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AreaServiceUser $areaServiceUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaServiceUser  $areaServiceUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(AreaServiceUser $areaServiceUser)
    {
        //
    }
}
