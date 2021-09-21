<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentPlans;
use App\Models\LetOutPlans;
use DB;

class PlansController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_rent_plans() {
        return $rent_plans = DB::table('rent_plans')->get();
    }

    public function get_letout_plans() {
        return $letout_plans = DB::table('let_out_plans')->get();
    }

    public function get_rent_features() {
        //return $rent_features = DB::table('rent_features')->groupBy('feature_name')->get();
        //return $rent_features = DB::table('rent_features')->select(DB::raw('feature_name, group_concat(feature_details) as feature_details'))->groupBy('feature_name')->get();
        return $rent_features = DB::table('rent_features')->orderBy('feature_id')->select(DB::raw('feature_name, group_concat(feature_details) as feature_details'))->groupBy('feature_name')->get();
    }

    public function get_letout_features() {
        return $letout_features = DB::table('let_out_features')->orderBy('id')->select(DB::raw('feature_name, group_concat(feature_details) as feature_details'))->groupBy('feature_name')->get();
    }
}
