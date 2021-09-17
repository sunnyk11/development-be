<?php

namespace App\Http\Controllers\Api;

use App\Models\product_order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\product;


class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    public function solid_properties()
    {
       $user_id = Auth::user()->id;

        $product_details= product::select('product_uid')->where(['user_id'=> $user_id])->get();
        $arr=[];
        foreach ($product_details as $key => $value) {
            array_push($arr,$value['product_uid']);
        }

        $data = product_order::with('Pro_order')->whereIn('product_id', $arr)->where('transaction_status', 'TXN_SUCCESS')->orderBy('id', 'desc')->get();
          return response()->json([
            'data' =>$data,
          ], 201);
    }
    public function purchase_properties()
    {
       $user_id = Auth::user()->id;
        $data = product_order::with('Pro_order')->where(['user_id'=> $user_id, 'transaction_status' => 'TXN_SUCCESS'])->orderBy('id', 'desc')->get();
          return response()->json([
            'data' =>$data,
          ], 201);
    }
     public function check_order_product(Request $request)
     {
        $product_id = $request->product_id;
        $user_email = Auth::user()->email;

        $product_details= product::where(['id'=> $product_id])->first();

        $product_order = product_order::where(['product_id'=>$product_details->product_uid,'status'=> '1'])->orderBy('id', 'desc')->orderBy('id', 'desc')->take(1)->get();

        return $product_order;
        
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
     * @param  \App\Models\product_order  $product_order
     * @return \Illuminate\Http\Response
     */
    public function show(product_order $product_order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product_order  $product_order
     * @return \Illuminate\Http\Response
     */
    public function edit(product_order $product_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product_order  $product_order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product_order $product_order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product_order  $product_order
     * @return \Illuminate\Http\Response
     */
    public function destroy(product_order $product_order)
    {
        //
    }
}
