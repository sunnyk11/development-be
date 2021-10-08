<?php

namespace App\Http\Controllers\Api;

use App\Models\ServiceUserReviews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

class ServiceUserReviewsController extends Controller
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
        // return $request->all();
        if($request->user_id){
            ServiceUserReviews::where(['user_id'=> $request->user_id,'s_user_id'=> $request->s_user_id])->update(['stars' =>$request->stars,'content'=>$request->content]);
              return response()->json([
                'message' => 'Review Updated',
                'data'    => $request->s_user_id,
            ],201);

        }
        else{
        // return $request->all();            
             $review = new ServiceUserReviews([
                'user_id' => Auth::user()->id,
                's_user_id' => $request->s_user_id,
                'stars' => $request->stars,
                'content' => $request->content,
            ]);
            $review->save();
             return response()->json([
                'message' => 'Review Submitted',
                'data'    => $request->s_user_id,
            ],201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceUserReviews  $serviceUserReviews
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceUserReviews $serviceUserReviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceUserReviews  $serviceUserReviews
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceUserReviews $serviceUserReviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceUserReviews  $serviceUserReviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceUserReviews $serviceUserReviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceUserReviews  $serviceUserReviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceUserReviews $serviceUserReviews)
    {
        //
    }
}
