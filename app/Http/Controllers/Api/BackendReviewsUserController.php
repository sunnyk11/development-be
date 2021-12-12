<?php

namespace App\Http\Controllers\Api;

use App\Models\backend_reviews_user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceImgReview;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BackendReviewsUserController extends Controller
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
            // return $db_img_length;
            if($request['data']['user_id']){
                backend_reviews_user::where(['user_id'=> $request['data']['user_id'],'s_user_id'=> $request['data']['s_user_id']])->update(['stars' =>$request['data']['stars'],'content'=>$request['data']['content']]);
                return response()->json([
                    'message' => 'Review Updated',
                    'data'    => $request['data']['s_user_id'],
                ],201);
            }
            else{
            $user_id=Auth::user()->id;            
                $review = new backend_reviews_user([
                    'user_id' => Auth::user()->id,
                    's_user_id' => $request['data']['s_user_id'],
                    'stars' => $request['data']['stars'],
                    'content' => $request['data']['content'],
                ]);
                $review->save();
                $review_id=$review->id;
                return response()->json([
                    'message' => 'Review Submitted',
                    'data'    => $request['data']['s_user_id'],
                ],201);
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend_reviews_user  $backend_reviews_user
     * @return \Illuminate\Http\Response
     */
    public function show(backend_reviews_user $backend_reviews_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend_reviews_user  $backend_reviews_user
     * @return \Illuminate\Http\Response
     */
    public function edit(backend_reviews_user $backend_reviews_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\backend_reviews_user  $backend_reviews_user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, backend_reviews_user $backend_reviews_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backend_reviews_user  $backend_reviews_user
     * @return \Illuminate\Http\Response
     */
    public function destroy(backend_reviews_user $backend_reviews_user)
    {
        //
    }
}
