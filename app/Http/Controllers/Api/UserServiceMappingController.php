<?php

namespace App\Http\Controllers\Api;;

use App\Models\User_service_mapping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\ServiceUserReviews;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserServiceMappingController extends Controller
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
     * @param  \App\Models\User_service_mapping  $user_service_mapping
     * @return \Illuminate\Http\Response
     */
    public function show(User_service_mapping $user_service_mapping)
    {
        //
    }
    
    public function search_data(Request $request){
        // return $request->all();
        try{
            $data = User_service_mapping::where(['status'=> '1'])->with('service','service_user','user_review')->search($request)->orderby('id','desc')->get();
            // return $data[0]['user_review'][1];
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
     * @param  \App\Models\User_service_mapping  $user_service_mapping
     * @return \Illuminate\Http\Response
     */
    public function edit(User_service_mapping $user_service_mapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User_service_mapping  $user_service_mapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_service_mapping $user_service_mapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User_service_mapping  $user_service_mapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_service_mapping $user_service_mapping)
    {
        //
    }
}
