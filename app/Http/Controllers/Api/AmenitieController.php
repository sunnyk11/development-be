<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Amenitie;
use Illuminate\Http\Request;

class AmenitieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Amenitie::where('IsEnable', '1')->orderBy('id', 'asc')->get();
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Amenitie  $amenitie
     * @return \Illuminate\Http\Response
     */
    public function show(Amenitie $amenitie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Amenitie  $amenitie
     * @return \Illuminate\Http\Response
     */
    public function edit(Amenitie $amenitie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Amenitie  $amenitie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Amenitie $amenitie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Amenitie  $amenitie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amenitie $amenitie)
    {
        //
    }
}
