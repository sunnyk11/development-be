<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\requirement;
use App\Models\eventtracker;
use Illuminate\Http\Request;
use Auth;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->usertype == 1){
            return response()->json([
                'unauthorised',
            ], 401);
        }

        $data = requirement::latest()->paginate(100);
        return response()->json([
            'data'=> $data,
        ], 201);
    }

    public function display()
    {

        if(Auth::user()->usertype == 1){
            return response()->json([
                'unauthorised',
            ], 401);
        }

        $data = requirement::where('delete_flag', 0)->latest()->paginate(100);
        return response()->json([
            'data'=> $data,
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request -> validate ([
            'rental_sale_condition' => 'required',
            'purchase_mode' => 'required',
            'cash_amount' => 'required',
            'loan_amount' => 'required',
            'property_type' => 'required',
            'requirement' => 'required',
        ]);

        $user_id = Auth::user()->id;

        $requirement = new Requirement([
            'user_id' => $user_id,
            'user_name' => Auth::user()->name,
            'rental_sale_condition' => $request->rental_sale_condition,
            'purchase_mode' => $request->purchase_mode,
            'cash_amount' => $request->cash_amount,
            'loan_amount' => $request->loan_amount,
            'property_type' => $request->property_type,
            'requirement' => $request->requirement
        ]);

        $requirement->save();
        eventtracker::create(['symbol_code' => '8', 'event' => Auth::user()->name.' posted a new requirement.']);


        return response()->json([
            'message' => 'Successfully inserted requirement',
            'data' => $requirement
        ], 201);
    }


    public function reqHandler(REquest $request)
    {
        $request -> validate([
            'user_id' => 'required',
        ]);

        $query = $request->user_id;

        $requirements = requirement::Where('user_id', 'like', '%' . $query . '%');

        $requirements = $requirements->paginate(4000);

        return response() -> json([
            'requirements' => $requirements,
        ]);

    }

    public function delete(Request $request)
    {

        $request->validate([
            'id' => 'required',
        ]);

        requirement::where('id', $request->id)->update(['delete_flag' => 1 ]);
        return response()->json([
            'message' => 'Successfully deleted Requirement',
        ], 201);

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
     * @param  \App\Models\requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function show(requirement $requirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function edit(requirement $requirement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, requirement $requirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(requirement $requirement)
    {
        //
    }
}
