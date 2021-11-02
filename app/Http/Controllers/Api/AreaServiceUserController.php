<?php

namespace App\Http\Controllers\Api;

use App\Models\AreaServiceUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\ServiceUserReviews;
use Auth;
use Illuminate\Support\Facades\DB;

class AreaServiceUserController extends Controller
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
        //
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
       $data = AreaServiceUser::where(['status'=> '1'])->with('service')->search($request)->with('user_review')->get();
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
