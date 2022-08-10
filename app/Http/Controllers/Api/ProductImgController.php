<?php

namespace App\Http\Controllers\Api;

use App\Models\Product_img;
use Illuminate\Http\Request;
use App\Models\product;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductImgController extends Controller
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

    public function get_pro_img_byid(Request $request){
        // return $request->product_id;
        $request->validate([
            'product_id' => 'required|integer'
        ]);
       try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $data=Product_img::select('id','user_id','product_id','image')->where(['product_id'=>$request->product_id ,'status'=>'1'])
                   ->get();
                 if(count($data)>0){
                    return response()->json([
                         'message' =>'SUCCESS',
                         'data' => $data,
                         'status'=>200
                     ], 200);
                  }else{
                    return response()->json([
                         'message' =>'FAIL',
                         'description' => 'Product Id is Invalid !!!...',
                         'status'=>200
                     ], 200);
                }
            }else{
                return response() -> json([
                    'message' => 'FAIL',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            }     
        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
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
        $request->validate([
                'product_id' => 'required|integer',
                'file'=>'required',
                'file.*' => 'image|mimes:jpeg,jpg,png|max:20480',
                'user_id'=>'required|integer'
            ]);

        $product_id = $request->input('product_id');
        $user_id = $request->input('user_id');
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                // return $request->file('file');
                if($request->file('file')){
                    foreach($request->file('file') as $file)
                    {
                        $ImageName = 'product_image_file/'.uniqid() . '-' .$file->getClientOriginalName();
                          $file->move(public_path('storage/product_image_file'), $ImageName);
                          
                               $Product_images_data = [
                                    'user_id' => $user_id,
                                    'product_id' => $product_id,
                                    'image' =>$ImageName 
                                ];
                         Product_img::create($Product_images_data);
                          
                    }
                        return response()->json([
                             'message' =>'SUCCESS',
                             'status'=>200
                         ], 200);
                }else{
                    return response()->json([
                         'message' =>'FAIL',
                         'description' => 'Please Select Product Image',
                         'status'=>404
                    ], 404);
                }
            }else{
                return response() -> json([
                    'message' => 'FAIL',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            }   
        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product_img  $product_img
     * @return \Illuminate\Http\Response
     */
    public function show(Product_img $product_img)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product_img  $product_img
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_img $product_img)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product_img  $product_img
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_img $product_img)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product_img  $product_img
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_img $product_img)
    {
        //
    }
     public function delete_pro_img (Request $request){

        $request->validate([
            'product_id' => 'required',
        ]);
        $product = Product_img::select('user_id','product_id')->where('id', $request->product_id)->first();
        $pro_id=$product['product_id']; 
        
        $user_id = Auth::user()->id;
        if ($user_id != $product['user_id'])
            return response()->json([
                'message' => 'Unauthorised User',
            ], 401);

        $image_result= Product_img::where([ 'user_id'=> $user_id,'product_id'=> $pro_id , 'id'=>$request->product_id ])->first();
        if(!empty($image_result['image'])){
            $image_path='storage/'.$image_result['image'];
            unlink($image_path);
        }
        Product_img::where([ 'user_id'=> $user_id,'product_id'=> $pro_id , 'id'=>$request->product_id ])->delete();

        return response()->json([
            'message' => 'Image Successfully deleted',
        ], 201);

    }
     public function delete_product_img_crm (Request $request){
        // return $request->all();
         $request->validate([
            'pro_image_id' => 'required|integer',
            'product_id' => 'required|integer'
        ]);
       try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $image_result= Product_img::where(['product_id'=> $request->product_id , 'id'=>$request->pro_image_id ])->first();
            if(!empty($image_result['image'])){
                $image_path='storage/'.$image_result['image'];
                unlink($image_path);
            }
            Product_img::where(['product_id'=>$request->product_id, 'id'=>$request->pro_image_id])->delete();

                return response()->json([
                    'message' => 'SUCCESS',
                    'description'=>'Image Successfully deleted',
                    'status'=>200
                ], 200);
            }else{
                return response() -> json([
                    'message' => 'FAIL',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            } 

        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        }  

    }
}
