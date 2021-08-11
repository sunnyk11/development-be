<?php

namespace App\Http\Controllers\Api;

use App\Models\UserProductCount;
use Illuminate\Http\Request;
use App\Models\eventtracker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;


class UserProductCountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $user_id = Auth::user()->id;
         $data=UserProductCount::where('user_id',$user_id)->with('productdetails')->orderBy('Product_count', 'desc')->take(6)->get();
        return response()->json([
            'data' => $data
        ], 200);
    }

     public function count_byID(Request $request)
    {
        $request->validate([
            'prod_id' => 'required',
        ]);
            $prod_id = $request->prod_id;
            $user_id = Auth::user()->id;

            $User_productCount = UserProductCount::where('user_id',$user_id)->where('product_id',$prod_id)->get();
            $count = count($User_productCount);
            if($count==0){
                $ProductCount= [
                    'user_id' => $user_id,
                    'product_id' =>$prod_id,
                    'Product_count' => 1
                ];
                UserProductCount::create($ProductCount);
                return response()->json([
                    'message' => 'Successfully increase Product Count',
                ], 201);
            }else{

              UserProductCount::where('product_id', $prod_id)->where('user_id', $user_id)->update(['Product_count'
                   => DB::raw('Product_count + 1')]);
                
                return response()->json([
                    'message' => 'Successfully update Product Count',
                ], 201);
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
     * @param  \App\Models\UserProductCount  $userProductCount
     * @return \Illuminate\Http\Response
     */
    public function show(UserProductCount $userProductCount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserProductCount  $userProductCount
     * @return \Illuminate\Http\Response
     */
    public function edit(UserProductCount $userProductCount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserProductCount  $userProductCount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserProductCount $userProductCount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProductCount  $userProductCount
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProductCount $userProductCount)
    {
        //
    }
}
