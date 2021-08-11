<?php

namespace App\Http\Controllers\Api;

use App\Models\lawyer;
use App\Models\eventtracker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lawyer_index()
    {
        $data = lawyer::where('delete_flag' , 0)->get();
        return response()->json([
            'data' => $data
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lawyer_create_service(Request $request)
    {

        if (Auth::user()->usertype != 4)
            return response()->json([
                'message' => 'Unauthorised User',
            ], 201);


        $request -> validate([
            'service_name' => 'required',
            'service_details' => 'required',
            'price' => 'required'
        ]);

        $user = Auth::user();


        $Lawyer = new Lawyer([
            'user_id' => $user->id,
            'name' => $user->name,
            'service_name' => $request->service_name,
            'service_details' => $request->service_details,
            'price' => $request->price
            ]);

        $Lawyer->save();
        eventtracker::create(['symbol_code' => '7', 'event' => Auth::user()->name.' posted a new lawyer service']);

        return response()->json([
            'added_service' => $Lawyer
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lawyer_service()
    {

        $data = lawyer::where('user_id', Auth::user()->id)->where('delete_flag', 0)->get();

        return response()->json([
            'data' => $data
        ]);

    }

    public function lawyer_service_delete(Request $request)
    {

        $request->validate([
            'id' => 'required',
        ]);


        $product_userid = lawyer::where('id', $request->id)->value('user_id');

        $user_id = Auth::user()->id;

        if ($user_id != $product_userid)
            return response()->json([
                'message' => 'Unauthorised User',
            ], 401);

        lawyer::where('id', $request->id)->update(['delete_flag' => 1 ]);
        return response()->json([
            'message' => 'Successfully deleted Service',
        ], 201);

    }

    public function lawyer_check(Request $request)
    {
        $request -> validate([
            'id' => 'required'
        ]);

        $lawyer = User::where('id', $request->id)->where('usertype', 4)->first();


        return response()->json([
            'data' => $lawyer
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lawyer  $lawyer
     * @return \Illuminate\Http\Response
     */
    public function show(lawyer $lawyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\lawyer  $lawyer
     * @return \Illuminate\Http\Response
     */
    public function edit(lawyer $lawyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\lawyer  $lawyer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, lawyer $lawyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lawyer  $lawyer
     * @return \Illuminate\Http\Response
     */
    public function destroy(lawyer $lawyer)
    {
        //
    }
}
