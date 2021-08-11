<?php

namespace App\Http\Controllers\Api;

use App\Models\savedsearches;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Database\Seeders\SavedsearchesSeeder;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SavedsearchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id = Auth::user()->id;

        $products = DB::table('savedsearches')->select('product_id')->where('user_id', $id)->get();

        return response() -> json ([
            'data' => $products
        ]);

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
        $request->validate([
            'product_id' => 'required'
        ]);


        $user_id = Auth::user()->id;

        $saved_searches = new Savedsearches([
            'user_id' => $user_id,
            'product_id' => $request->product_id
        ]);

        $saved_searches -> save();

        return response() -> json ([
            'message' => 'success'
        ], 201);

    }



        /**     rches
     * @return \Illuminate\Http\Response
     */
    public function show(savedsearches $savedsearches)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\savedsearches  $savedsearches
     * @return \Illuminate\Http\Response
     */
    public function edit(savedsearches $savedsearches)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\savedsearches  $savedsearches
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, savedsearches $savedsearches)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\savedsearches  $savedsearches
     * @return \Illuminate\Http\Response
     */
    public function destroy(savedsearches $savedsearches)
    {
        //
    }
}
