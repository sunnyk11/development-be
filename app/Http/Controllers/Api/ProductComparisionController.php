<?php

namespace App\Http\Controllers\Api;

use App\Models\Product_Comparision;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ProductComparisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $user_id = Auth::user()->id;
            $data=Product_Comparision::where('status', '1')->where('user_id',$user_id)->with('productdetails','amenities')->orderBy('id', 'asc')->take('4')->get();
            return response()->json([
                'data' => $data
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }

    public function get_mobile_comp()
    {
        try{
            $user_id = Auth::user()->id;
            $data=Product_Comparision::where('status', '1')->where('user_id',$user_id)->with('productdetails','amenities')->orderBy('id', 'asc')->take('2')->get();
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
        try{
            $product_id=$request->param['id'];
            $user_id = Auth::user()->id;
             $pro_user_data = Product_Comparision::where(['user_id'=>$user_id,'status'=>'1'])->get();
            if(count($pro_user_data)<4){
                    $product_comp = [
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                    ];
                    Product_Comparision::create($product_comp);
                return response()->json([
                    'cart_data'=> count($pro_user_data),
                    'message' => 'Successfully Added Property Comparision',
                        'status'=>201
                    ], 201);

               
          }else{
             return response()->json([
                'cart_data'=> count($pro_user_data),
                    'message' => 'comparing list are the full',
                    'status'=>304
                ], 200);

          }
       }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
      public function product_comp_mobile_store(Request $request)
        {
            try{
                $product_id=$request->param['id'];
                $user_id = Auth::user()->id;
                 $pro_user_data = Product_Comparision::where(['user_id'=>$user_id,'status'=>'1'])->get();
                if(count($pro_user_data)<2){
                        $product_comp = [
                            'user_id' => $user_id,
                            'product_id' => $product_id,
                        ];
                        Product_Comparision::create($product_comp);
                    return response()->json([
                        'cart_data'=> count($pro_user_data),
                        'message' => 'Successfully Added Property Comparision',
                            'status'=>201
                        ], 201);

                   
              }else{
                 return response()->json([
                    'cart_data'=> count($pro_user_data),
                        'message' => 'comparing list are the full',
                        'status'=>304
                    ], 200);

              }
           }catch(\Exception $e) {
                return $this->getExceptionResponse($e);
            }
        }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product_Comparision  $product_Comparision
     * @return \Illuminate\Http\Response
     */
    public function show(Product_Comparision $product_Comparision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product_Comparision  $product_Comparision
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_Comparision $product_Comparision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product_Comparision  $product_Comparision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_Comparision $product_Comparision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product_Comparision  $product_Comparision
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_Comparision $product_Comparision)
    {
        //
    }
    public function delete(Request $request)
    {
        try{
            $user_id = Auth::user()->id;
            $data= Product_Comparision::where(['user_id'=>$user_id,'product_id'=>$request->id])->delete();

                return response()->json([
                    'message' => 'Property Compare Successfully Deleted ',
                ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 

    }
}
