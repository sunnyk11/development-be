<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\eventtracker;
use Illuminate\Http\Request;

class EventtrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = eventtracker::Latest()->paginate(10);

        return response()->json([
            'data' => $data,
        ], 201);

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
     * @param  \App\Models\eventtracker  $eventtracker
     * @return \Illuminate\Http\Response
     */
    public function show(eventtracker $eventtracker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\eventtracker  $eventtracker
     * @return \Illuminate\Http\Response
     */
    public function edit(eventtracker $eventtracker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\eventtracker  $eventtracker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, eventtracker $eventtracker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\eventtracker  $eventtracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(eventtracker $eventtracker)
    {
        //
    }
}
