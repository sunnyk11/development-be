<?php

namespace App\Http\Controllers\Api;;

use App\Models\area_state;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data=area_state::where('status', '1')->orderBy('state_id', 'asc')->get();
            return response()->json([
                'data' => $data
            ], 200);
       }catch(\Exception $e) {
        return $this->getExceptionResponse($e);
        }
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
     * @param  \App\Models\area_state  $area_state
     * @return \Illuminate\Http\Response
     */
    public function show(area_state $area_state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\area_state  $area_state
     * @return \Illuminate\Http\Response
     */
    public function edit(area_state $area_state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\area_state  $area_state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, area_state $area_state)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\area_state  $area_state
     * @return \Illuminate\Http\Response
     */
    public function destroy(area_state $area_state)
    {
        //
    }
}
