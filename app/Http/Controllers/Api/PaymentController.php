<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use PaytmChecksum;
use App\Models\product;
use App\Models\product_order;
use App\Models\product_transaction;
use Illuminate\Support\Facades\DB;
use App\Models\Wishlist;
use App\Models\Product_Comparision;

class PaymentController extends Controller
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

    public function payment(Request $request)
    {
        try {
           $product_id=$request->id;
           $MOBILE_NO = Auth::user()->other_mobile_number;
           $EMAIL =  Auth::user()->email;
           $CUST_ID = Auth::user()->id;
           $order_id= 'OR'.rand (10,100).time();

            // product details get from databse
            $product_details= product::where(['id'=> $product_id])->first();
             $pro_order = [
                'product_id'  =>  $product_details->product_uid,
                'user_email'  =>  $EMAIL,
                'user_id'     =>  $CUST_ID, 
                'orderId'     =>  $order_id,
                'plans_type'  =>  $request->plans_type
              ];
              // return $pro_order;
             // order save on database by Unique order id
             product_order::create($pro_order);

            $body = [
                "MID"              => getenv("MID"),
                "WEBSITE"          => getenv("WEBSITE"),
                "INDUSTRY_TYPE_ID" => getenv("INDUSTRY_TYPE_ID"),
                "ORDER_ID"         => $order_id,
                "CALLBACK_URL"     => getenv("CALLBACK_URL"),
                "TXN_AMOUNT"       => $product_details->expected_rent,
                "CUST_ID"          => $CUST_ID,
                "MOBILE_NO"        => $MOBILE_NO,
                "EMAIL"            =>  $EMAIL
            ];
             
            $paytmChecksum = PaytmChecksum::generateSignature($body, 'G1wjysZljdRKqMzm');
            $body["CHECKSUMHASH"] = $paytmChecksum;
            
            $jsonbody = json_encode($body);
            error_log($jsonbody);
         
            return response()->json([
                'data' => $body,
                'status' => 201
                
            ], 200);
        } catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
       
    }
    public function postPayment(Request $request){
        try {   
            $pro_tranaction= [
                'order_id'           =>  $request->ORDERID,
                'MID'                =>  $request->MID,
                'transaction_id'     =>  $request->TXNID,
                'transaction_amount' =>  $request->TXNAMOUNT,
                'transaction_status' =>  $request->STATUS,
                'transaction_date'   =>  $request->TXNDATE,
                'respcode'           =>  $request->RESPCODE,
                'resp_message'       =>  $request->RESPMSG,
                'getwayname'         =>  $request->GATEWAYNAME,
                'bank_txn_id'        =>  $request->BANKTXNID,
                'bank_name'          =>  $request->BANKNAME,
                'checksumhash'       =>  $request->CHECKSUMHASH,
                'paymentmode'        =>  $request->PAYMENTMODE,
                'currency'           =>  $request->CURRENCY,
                'retryAllowed'       =>  $request->retryAllowed,
                'errorMessage'       =>  $request->errorMessage,
                'errorCode'          =>  $request->errorCode
            ];  

            // transaction save on database by Unique order id
            product_transaction::create($pro_tranaction);

            // transaction status update
            product_order::where('orderId', $request->ORDERID)->update(['transaction_status' => $request->STATUS]);

            // product id fetch databse
            $product_uid= product_order::where('orderId', $request->ORDERID)->first();
            // product id fetch databse
            $product_id= product::where('product_uid', $product_uid->product_id)->first();
            

            // product disable after payment
            if($request->STATUS == 'TXN_SUCCESS'){ 
              product::where('id', $product_id->id)->update(['order_status' => '1']);
              /* Wishlist disabled by ID */
              Wishlist::where('product_id', $product_id->id)->update(['status' => '0']);
                /* Product comparison disabled by ID */
              Product_Comparision::where('product_id', $product_id->id)->update(['status' => '0']);
            }

            $angular_url='http://localhost:4200/productpage?id='.$product_id->id.'&status='.$request->RESPCODE;
            
            return response()->redirectTo($angular_url);     
        }catch (\Exception $e) {
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
