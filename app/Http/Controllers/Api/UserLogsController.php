<?php

namespace App\Http\Controllers\Api;

use App\Models\user_logs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "testing";
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
            $user_logs= [
                'url'            =>  $request->url_info,
                'product_id'     =>  $request->pro_id,
                'system_ip'      =>  $request->ip_address,
                'device_info'    =>  $request->device_info,
                'browser_info'   =>  $request->browser_info,
                'type'           =>  $request->type,
                'user_email'     =>  $request->userEmail,
                'input_info'     =>  json_encode($request->input_info),
                'user_cart'      =>  json_encode($request->user_cart)
            ];
            // return $user_logs;
            user_logs::create($user_logs);
            return response()->json([
                    'message' => 'Successfuly saved',
                    'status' => 200
                    
                ], 200);

        }catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user_logs  $user_logs
     * @return \Illuminate\Http\Response
     */
    public function show(user_logs $user_logs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user_logs  $user_logs
     * @return \Illuminate\Http\Response
     */
    public function edit(user_logs $user_logs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user_logs  $user_logs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user_logs $user_logs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user_logs  $user_logs
     * @return \Illuminate\Http\Response
     */
    public function destroy(user_logs $user_logs)
    {
        //
    }
}
