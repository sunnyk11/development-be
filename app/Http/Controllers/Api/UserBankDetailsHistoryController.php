<?php

namespace App\Http\Controllers\Api;;

use App\Models\user_bank_details_history;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserBankDetailsHistoryController extends Controller
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
   public function get_userbank_history_id(Request $request){
       try{
            $user_history= user_bank_details_history::where('user_id', $request->user_id)->take(5)->get();
            return response()->json([
                    'data' => $user_history,
                    'status'=>200
                ]);
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
     * @param  \App\Models\user_bank_details_history  $user_bank_details_history
     * @return \Illuminate\Http\Response
     */
    public function show(user_bank_details_history $user_bank_details_history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user_bank_details_history  $user_bank_details_history
     * @return \Illuminate\Http\Response
     */
    public function edit(user_bank_details_history $user_bank_details_history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user_bank_details_history  $user_bank_details_history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user_bank_details_history $user_bank_details_history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user_bank_details_history  $user_bank_details_history
     * @return \Illuminate\Http\Response
     */
    public function destroy(user_bank_details_history $user_bank_details_history)
    {
        //
    }
}
