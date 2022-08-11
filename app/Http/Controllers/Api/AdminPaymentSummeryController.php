<?php

namespace App\Http\Controllers\Api;

use App\Models\admin_payment_summery;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\API\payment_resource;

class AdminPaymentSummeryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         try{
            $data = admin_payment_summery::orderBy('id', 'desc')->with('pro_owner','pro_created_user','productdetails')->paginate(5);
            return response()->json([
                'data' => $data
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }



    public function get_property_payment($user_id) {
        // try{
        $property_details = admin_payment_summery::with('pro_owner','pro_created_user','productdetails')->where(['property_owner' => $user_id, 'status' => '1','payment_type'=>'Property Payment'])->get();

        $other_payment = admin_payment_summery::with('pro_owner','pro_created_user','productdetails')->where(['property_owner' => $user_id, 'status' => '1','payment_type'=>'Any other Payment'])->get();
        return response()->json([
                'data' => $property_details,
                'other_payment'=>$other_payment
            ], 200);
        // }catch(\Exception $e) {
        //     return $this->getExceptionResponse1($e);
        // } 
    }
    public function get_payment_user(Request $request)
    {
         try{
            $data = admin_payment_summery::orderBy('id', 'desc')->with('pro_owner','pro_created_user','productdetails')->search($request)->paginate(5);
            return response()->json([
                'data' => $data,
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    public function get_payment_user_excel(Request $request)
    {
         try{
            $excel_data=admin_payment_summery::orderBy('id', 'desc')->search($request)->with('pro_owner','pro_created_user','productdetails')->get();
               
             $excel_data1= payment_resource::collection($excel_data);
            return response()->json([
                'data'=>$excel_data1
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
        $request->validate([
                'amount' => 'required',
                'payment_user' => 'required|integer',
                'payment_status' => 'required',
                'transaction_id' => 'required',
                'message' => 'required',
                'payment_type' => 'required',
                'bank_details_json' => 'required'
             ]);   
        try{
     $property_details = admin_payment_summery::select('product_id','payment_image')->where(['product_id' => $request->product,'property_owner' => $request->payment_user,'payment_status'=>'Success'])->first();
     $imageName=NULL;
     if($property_details){
         admin_payment_summery::select('product_id')->where(['product_id' => $request->product,'property_owner' => $request->payment_user,'payment_status'=>'Success'])->delete();
         $image_path='storage/'.$property_details['payment_image'];
            unlink($image_path);
            if($request->payment_image){
                $base64_image = $request->payment_image; // your base64 encoded
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);
                    $imageName = 'transaction/IMAGE'.Str::random(30).'.'.'png';
                    Storage::disk('public')->put($imageName, base64_decode($file_data));
            }
         
            $created_user = Auth::user()->id;
            $admin_payment_data =[
                'created_user' =>$created_user ,
                'product_id' =>$request->product,
                'payment_image' =>$imageName,
                'amount' =>$request->amount,
                'property_owner' =>$request->payment_user ,
                'payment_status' =>$request->payment_status,
                'transaction_id' =>$request->transaction_id,
                'payment_type'=> $request->payment_type,
                'message' => $request->message,
                'bank_details_json' =>json_encode($request->bank_details_json)
            ];
             
            // return $admin_payment_data;
             admin_payment_summery::create($admin_payment_data);
             if($request->payment_status=='Success'){
                product::where('id', $request->product)->update(['payment_status' => '1']);
             }
            return response() -> json([
                'message' => 'Successfully created',
                'status' =>201
             ]);
     }else{

            if($request->payment_image){
                $base64_image = $request->payment_image; // your base64 encoded
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);
                    $imageName = 'transaction/IMAGE'.Str::random(30).'.'.'png';
                    Storage::disk('public')->put($imageName, base64_decode($file_data));
            }
            $created_user = Auth::user()->id;
            $admin_payment_data =[
                'created_user' =>$created_user ,
                'product_id' =>$request->product,
                'payment_image' =>$imageName,
                'amount' =>$request->amount,
                'property_owner' =>$request->payment_user ,
                'payment_status' =>$request->payment_status,
                'transaction_id' =>$request->transaction_id,
                'payment_type'=> $request->payment_type,
                'message' => $request->message,
                'bank_details_json' =>json_encode($request->bank_details_json)
            ];
             
            // return $admin_payment_data;
             admin_payment_summery::create($admin_payment_data);

             if($request->payment_status=='Success'){
                product::where('id', $request->product)->update(['payment_status' => '1' ]);
             }
            return response() -> json([
                'message' => 'Successfully created',
                'status' =>201
             ]);
     }
         

        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin_payment_summery  $admin_payment_summery
     * @return \Illuminate\Http\Response
     */
    public function show(admin_payment_summery $admin_payment_summery)
    {
        //
    }
    
    public function payment_status_update(Request $request)
    {
        try{
              $property_details = admin_payment_summery::select('product_id')->where(['id'=> $request->payment_id])->first();
              $sign_up_user = admin_payment_summery::where(['id'=> $request->payment_id])->update(['payment_status'=>$request->payment_status]);
              if($request->payment_status=='Success'){
                product::where('id',$property_details->product_id)->update(['payment_status' => '1']);
             }else{
                product::where('id',$property_details->product_id)->update(['payment_status' => '0']);

             }
        return response()->json([
              'message' =>'data updated',
              'status'=>201
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin_payment_summery  $admin_payment_summery
     * @return \Illuminate\Http\Response
     */
    public function edit(admin_payment_summery $admin_payment_summery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin_payment_summery  $admin_payment_summery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, admin_payment_summery $admin_payment_summery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin_payment_summery  $admin_payment_summery
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin_payment_summery $admin_payment_summery)
    {
        //
    }
}
