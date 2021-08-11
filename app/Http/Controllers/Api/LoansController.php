<?php

namespace App\Http\Controllers\Api;

use App\Models\loans;
use App\Models\eventtracker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;


class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => loans::where('delete_flag', 0)->get()
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function first(Request $request)
    {
        $request -> validate([
            'bank' => 'required',
            'address' => 'required' ,
            'interest_rate' => 'required' ,
            'type' => 'required',
        ]);


        $loan_data = new loans([
            'bank' => $request->bank,
            'address' => $request->address,
            'interest_rate' => $request->interest_rate,
            'type' => $request->type,
            'delete_flag' => 0
        ]);

        $user_type = Auth::user()->usertype;

        if ($user_type < 6)
            return response()->json([
                'message' => 'Unauthorised User',
            ], 401);

        $loan_data-> save();
        eventtracker::create(['symbol_code' => '10', 'event' => Auth::user()->name.' created a new Loan listing.']);


        return response()->json([
                'message' => 'Successfully inserted product for sale',
            ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loan_delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);




        $user_id = Auth::user()->usertype;

        if ($user_id < 6)
            return response()->json([
                'message' => 'Unauthorised User',
            ], 401);

        loans::where('id', $request->id)->update(['delete_flag' => 1 ]);
        return response()->json([
            'message' => 'Successfully deleted Loan',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\loans  $loans
     * @return \Illuminate\Http\Response
     */
    public function show(loans $loans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\loans  $loans
     * @return \Illuminate\Http\Response
     */
    public function edit(loans $loans)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\loans  $loans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, loans $loans)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\loans  $loans
     * @return \Illuminate\Http\Response
     */
    public function destroy(loans $loans)
    {
        //
    }
}
