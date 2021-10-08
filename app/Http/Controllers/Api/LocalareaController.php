<?php

namespace App\Http\Controllers\Api;

use App\Models\localarea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocalareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data=localarea::where('status', '1')->orderBy('id', 'desc')->get();
        return response()->json([
            'data' => $data
        ], 200);
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

    public function get_localareaby_id(Request $request) {
         $data = localarea::where('Area_id', $request->id)->get();
        return response()->json([
            'data' =>$data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\localarea  $localarea
     * @return \Illuminate\Http\Response
     */
    public function show(localarea $localarea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\localarea  $localarea
     * @return \Illuminate\Http\Response
     */
    public function edit(localarea $localarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\localarea  $localarea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, localarea $localarea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\localarea  $localarea
     * @return \Illuminate\Http\Response
     */
    public function destroy(localarea $localarea)
    {
        //
    }
}
