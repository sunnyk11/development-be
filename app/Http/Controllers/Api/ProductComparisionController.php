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
        $product_id=$request->param['id'];
        // user fetch using databse
        $user_id = Auth::user()->id;
        // fetch details property Comparision minimum 5
         $pro_user_data = Product_Comparision::where(['user_id'=>$user_id,'status'=>'1'])->get();
        if(count($pro_user_data)<4){
            // fetch details user product db        
            $pro_comp = Product_Comparision::where(['user_id'=>$user_id,'product_id'=>$request->product_id])->get();
            $count = count($pro_comp);

            if($count==0){
                $product_comp = [
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                ];
                Product_Comparision::create($product_comp);
                $data = Product_Comparision::where('status', '1')->where('user_id',$user_id)->get();

            return response()->json([
                    'data' =>$data,
                    'message' => 'Successfully Added Property Comparision',
                ], 201);

            }else{
                $update_data= Product_Comparision::where(['user_id'=>$user_id,'product_id'=>$product_id])->update(['status' => '1']); 
                $data = Product_Comparision::where('status', '1')->where('user_id',$user_id)->get();
              return response()->json([
                'data' =>$data,
            ], 201);           
            }
      }else{
        $data = Product_Comparision::where('status', '1')->where('user_id',$user_id)->get();
         return response()->json([
              'data' =>$data,
                'message' => 'Cart Are the full',
            ], 201);

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
        $pro_comp_data = array('user_id'=>$user_id,'product_id'=>$request->id);

        $data= Product_Comparision::where(['user_id'=>$user_id,'product_id'=>$request->id])->delete();

            return response()->json([
                'message' => 'Property Compare Successfully Deleted ',
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
      } 

    }
}
