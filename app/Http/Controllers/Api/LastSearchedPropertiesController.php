<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\last_searched_properties;
use Illuminate\Http\Request;

class LastSearchedPropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
     * @param  \App\Models\last_searched_properties  $last_searched_properties
     * @return \Illuminate\Http\Response
     */
    public function show(last_searched_properties $last_searched_properties)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\last_searched_properties  $last_searched_properties
     * @return \Illuminate\Http\Response
     */
    public function edit(last_searched_properties $last_searched_properties)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\last_searched_properties  $last_searched_properties
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, last_searched_properties $last_searched_properties)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\last_searched_properties  $last_searched_properties
     * @return \Illuminate\Http\Response
     */
    public function destroy(last_searched_properties $last_searched_properties)
    {
        //
    }
}
