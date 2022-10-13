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
use App\Models\plansOrders;
use App\Models\plansRentOrders;
use App\Models\plansTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\Wishlist;
use App\Models\Product_Comparision;
use App\Models\planCredit;
use Carbon\Carbon;
use App\Models\invoices;
use App\Models\UserProductCount;

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
             
            $Payment_argument=getenv("Payment_Parameter");
            $paytmChecksum = PaytmChecksum::generateSignature($body,$Payment_argument);
            // $paytmChecksum = PaytmChecksum::generateSignature($body, 'G1wjysZljdRKqMzm');
            $body["CHECKSUMHASH"] = $paytmChecksum;
            
            $jsonbody = json_encode($body);
            // error_log($jsonbody);
         
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
            $exist_order= [
                'order_id' =>$request->ORDERID
              ];
            // plansTransaction::create($plan_transaction);
            
            plansTransaction::updateOrCreate($exist_order, $pro_tranaction);

            // transaction save on database by Unique order id
            // product_transaction::create($pro_tranaction);

            // transaction status update
            product_order::where('orderId', $request->ORDERID)->update(['transaction_status' => $request->STATUS]);

            // product id fetch databse
            $product_uid= product_order::where('orderId', $request->ORDERID)->first();
            // product id fetch databse
            $product_id= product::where('product_uid', $product_uid->product_id)->first();
            

            // product disable after payment
            if($request->STATUS == 'TXN_SUCCESS'){ 
              product::where('id', $product_id->id)->update(['order_status' => '1']);
              UserProductCount::where('product_id', $order_details->property_id)->update(['status' => '0']);
              /* Wishlist disabled by ID */
              Wishlist::where('product_id', $product_id->id)->update(['status' => '0']);
                /* Product comparison disabled by ID */
              Product_Comparision::where('product_id', $product_id->id)->update(['status' => '0']);
            }

            $angular_url = env('angular_url').'product-details?id='.$product_id->id.'&status='.$request->RESPCODE;
            
            return response()->redirectTo($angular_url);     
        }catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    public function plans_payment($orderID) {

        try {
            $order_id=$orderID;
            $MOBILE_NO = Auth::user()->other_mobile_number;
            $EMAIL =  Auth::user()->email;
            $CUST_ID = Auth::user()->id;

            $order_details = DB::table('plans_orders')->where('order_id', $order_id)->get();
            if($order_details[0]->invoice_no != NULL) {
                return response()->json([
                    'message' => 'Order has already been processed'   
                ]);
            }
            $price = $order_details[0]->plan_price;
            $gst_price = round((18 * $price) / 100);
            $total_price = $price + $gst_price;

             $body = [
                 "MID"              => getenv("MID"),
                 "WEBSITE"          => getenv("WEBSITE"),
                 "INDUSTRY_TYPE_ID" => getenv("INDUSTRY_TYPE_ID"),
                 "ORDER_ID"         => $order_id,
                 "CALLBACK_URL"     => getenv("CALLBACK_URL_PLANS"),
                 "TXN_AMOUNT"       => $total_price,
                 "CUST_ID"          => $CUST_ID,
                 "MOBILE_NO"        => $MOBILE_NO,
                 "EMAIL"            =>  $EMAIL
             ];
              
             
             $Payment_argument=getenv("Payment_Parameter");
             $paytmChecksum = PaytmChecksum::generateSignature($body,$Payment_argument);
            //  $paytmChecksum = PaytmChecksum::generateSignature($body, 'G1wjysZljdRKqMzm');
             $body["CHECKSUMHASH"] = $paytmChecksum;
             
             $jsonbody = json_encode($body);
            //  error_log($jsonbody);
          
             return response()->json([
                 'data' => $body,
                 'status' => 201
                 
             ], 200);
         } 
         catch (\Exception $e) {
             return $this->getExceptionResponse($e);
         }

    }

    public function PlansPostPayment(Request $request) {

        try {   

            $validate = $request->validate([
                'order_id' => 'unique:invoices'
            ]);

            $plan_transaction= [
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
            
            $exist_order= [
                'order_id' =>$request->ORDERID
              ];
            // plansTransaction::create($plan_transaction);
            
            plansTransaction::updateOrCreate($exist_order, $plan_transaction);

            // transaction status update
            plansOrders::where('order_id', $request->ORDERID)->update(['transaction_status' => $request->STATUS]);

            if($request->STATUS == 'TXN_SUCCESS') {
                $year = Carbon::now()->format('y');
                $month = Carbon::now()->format('m');
                $day = Carbon::now()->format('d');
                $hour = Carbon::now()->format('h');
                $minute = Carbon::now()->format('i');
                $second = Carbon::now()->format('s');
                
                //$invoice_id = 'INV'.rand (10,100).time();
                $invoice_id = 'INV' . $year . $month . $day . $hour . $minute . $second;
                plansOrders::where('order_id', $request->ORDERID)->update(['amount_paid' => $request->TXNAMOUNT, 'invoice_no' => $invoice_id, 'payment_status' => 'PAID']);

                $order_details = DB::table('plans_orders')->where('order_id', $request->ORDERID)->get();
                $user_email = $order_details[0]->user_email;
                $credit_details = DB::table('plan_credits')->where('user_email', $user_email)->get();

                $credit = new planCredit([
                    'user_id' => $order_details[0]->user_id,
                    'user_email' => $order_details[0]->user_email,
                    'payment_status' => 'PAID',
                    'credits' => $order_details[0]->expected_rent,
                    'invoice_no' => $order_details[0]->invoice_no
                ]);

                $credit->save();

                $todayDate =  Carbon::now()->format('Y-m-d H:i:s');
                
               $exist_invoice= [
                'invoice_no' => $invoice_id
              ];

                $invoice =[
                    'invoice_no' => $invoice_id,
                    'plan_name' => $order_details[0]->plan_name,
                    'plan_id' => $order_details[0]->plan_id,
                    'plan_type' => $order_details[0]->plan_type,
                    'payment_type' => $order_details[0]->payment_type,
                    'order_id' => $order_details[0]->order_id,
                    'expected_rent' => $order_details[0]->expected_rent,
                    'plan_price' => $order_details[0]->plan_price,
                    'payment_status' => 'PAID',
                    'user_email' => $order_details[0]->user_email,
                    'user_id' => $order_details[0]->user_id,
                    'invoice_generated_date' => $todayDate,
                    'invoice_paid_date' => $todayDate,
                    'amount_paid' => $request->TXNAMOUNT,
                    'transaction_status' => $request->STATUS,
                    'payment_mode' => 'Online',
                    'payment_received' => 'Yes'     
                ];

                invoices::updateOrCreate($exist_invoice, $invoice);
                // $invoice->save();
                
                /*$total_credit = DB::table('total_credits')->where('user_email', $user_email)->get();
                if($total_credit->isEmpty()) {
                    
                    $tot_credit = new totalCredits([
                        'user_id' => $order_details[0]->user_id,
                        'user_email' => $order_details[0]->user_email,
                        'total_credits' => $order_details[0]->expected_rent
                    ]);

                    $tot_credit->save();
                }
                else {
                    $existing_credit = $total_credit[0]->total_credits;
                    $new_credit = $existing_credit + $order_details[0]->expected_rent;
                    totalCredits::where('user_email', $user_email)->update(['total_credits' => $new_credit]);
                } */
                
                //$angular_url = env('angular_url').'invoice?'.'invoice_no='.$invoice_id;

              // $property_uid=invoices::select('property_uid')->where('order_id', )->first();


                $angular_url = env('angular_url').'agent/my-properties';
            }
            else {
                plansOrders::where('order_id', $request->ORDERID)->update(['payment_status' => 'FAIL']);
                $angular_url = env('angular_url').'plans?'.'status='.$request->RESPCODE;
            }
            
            return response()->redirectTo($angular_url);     
        }
        catch (\Exception $e) {
            //return $this->getExceptionResponse($e);
            if ($e->getCode() === '23000') {
                /* $error = "This order has already been processed";
                return response()->json([
                    'message' => $error   
                ]); */
                return redirect()->to(env('APP_REDIRECT_URL'));
               // return redirect()->to(env('APP_REDIRECT_URL'))->withErrors($error);
            }
        }
    }

    public function plans_rent_payment($orderId) {
        try {
            $order_details = DB::table('plans_rent_orders')->where('order_id', $orderId)->get();
            $MOBILE_NO = Auth::user()->other_mobile_number;
            $EMAIL =  Auth::user()->email;
            $CUST_ID = Auth::user()->id;

             $body = [
                 "MID"              => getenv("MID"),
                 "WEBSITE"          => getenv("WEBSITE"),
                 "INDUSTRY_TYPE_ID" => getenv("INDUSTRY_TYPE_ID"),
                 "ORDER_ID"         => $orderId,
                 "CALLBACK_URL"     => getenv("CALLBACK_URL_RENT_PLANS"),
                 "TXN_AMOUNT"       => $order_details[0]->amount_paid,
                 "CUST_ID"          => $CUST_ID,
                 "MOBILE_NO"        => $MOBILE_NO,
                 "EMAIL"            => $EMAIL
             ];
             $Payment_argument=getenv("Payment_Parameter");
             $paytmChecksum = PaytmChecksum::generateSignature($body,$Payment_argument);
             $body["CHECKSUMHASH"] = $paytmChecksum;
             
             $jsonbody = json_encode($body);
            //  error_log($jsonbody);
          
             return response()->json([
                 'data' => $body,
                 'status' => 201
                 
             ], 200);
         } 
         catch (\Exception $e) {
             return $this->getExceptionResponse($e);
         }

    }

    public function remaing_plans_rent_payment($orderId) {
            try {
                $order_details = DB::table('plans_rent_orders')->where('order_id', $orderId)->get();
                $remaing_amount=$order_details[0]->total_amount-$order_details[0]->amount_paid;
                $MOBILE_NO = Auth::user()->other_mobile_number;
                $EMAIL =  Auth::user()->email;
                $CUST_ID = Auth::user()->id;

                 $body = [
                     "MID"              => getenv("MID"),
                     "WEBSITE"          => getenv("WEBSITE"),
                     "INDUSTRY_TYPE_ID" => getenv("INDUSTRY_TYPE_ID"),
                     "ORDER_ID"         =>$order_details[0]->book_order_id,
                     "CALLBACK_URL"     => getenv("CALLBACK_URL_RENT_PLANS_REMAIN"),
                     "TXN_AMOUNT"       =>$remaing_amount,
                     "CUST_ID"          => $CUST_ID,
                     "MOBILE_NO"        => $MOBILE_NO,
                     "EMAIL"            => $EMAIL
                 ];
                 $Payment_argument=getenv("Payment_Parameter");
                 $paytmChecksum = PaytmChecksum::generateSignature($body,$Payment_argument);
                 $body["CHECKSUMHASH"] = $paytmChecksum;
                 
                 $jsonbody = json_encode($body);
                //  error_log($jsonbody);
              
                 return response()->json([
                     'data' => $body,
                     'status' => 201
                     
                 ], 200);
             } 
             catch (\Exception $e) {
                 return $this->getExceptionResponse($e);
             }

        }

    public function PlansRentPostPayment(Request $request) {
        try {   

            $order_details = plansRentOrders::where('order_id', $request->ORDERID)->first();
            $plan_transaction= [
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
            $exist_order= [
                'order_id' =>$request->ORDERID
              ];            
            plansTransaction::updateOrCreate($exist_order, $plan_transaction);

            // transaction status update
            plansRentOrders::where('order_id', $request->ORDERID)->update(['transaction_status' => $request->STATUS]);

            if($request->STATUS == 'TXN_SUCCESS') {
                $year = Carbon::now()->format('y');
                $month = Carbon::now()->format('m');
                $day = Carbon::now()->format('d');
                $hour = Carbon::now()->format('h');
                $minute = Carbon::now()->format('i');
                $second = Carbon::now()->format('s');
                $x=1;
                //$invoice_id = 'INV'.rand (10,100).time();

                $order_details = DB::table('plans_rent_orders')->where('order_id', $request->ORDERID)->get();

                $invoice_id = 'INV' . $year . $month . $day . $hour . $minute . $second.$x;
                
                plansRentOrders::where('order_id', $request->ORDERID)->update([ 'invoice_no' => $invoice_id, 'payment_status' => 'PAID']); 

                $user_email = $order_details[0]->user_email;

                $todayDate = Carbon::now()->format('Y-m-d H:i:s');
                
                 $invoice_rentout=  invoices::where(['property_uid'=> $order_details[0]->property_uid,'user_email' => $order_details[0]->user_email,'plan_name'=>$order_details[0]->plan_name,'payment_status'=>'PAID','plan_status' => 'used','payment_type'=>'Post','plan_type'=>'Rent'])->where('payment_percentage','100')->first();
               if($invoice_rentout){
                  $angular_url = env('angular_url').'invoice?'.'invoice_no='.$invoice_rentout->invoice_no;
            
               }else{

                if($order_details[0]->choose_payment_type=='purchase_property'){
                       $exist_invoice= [
                        'invoice_no' => $invoice_id
                      ];

                      $invoice =[
                          'invoice_no' => $invoice_id,
                          'plan_name' => $order_details[0]->plan_name,
                          'plan_id' => $order_details[0]->plan_id,
                          'plan_type' => $order_details[0]->plan_type,
                          'payment_type' => $order_details[0]->payment_type,
                          'order_id' => $order_details[0]->order_id,
                          'expected_rent' => $order_details[0]->expected_rent,
                          'plan_price' => $order_details[0]->plan_price,

                          'agreement_price' =>$order_details[0]->agreement_price,
                          'payment_status' => 'PAID',
                          'plan_status'=>'used',
                          'user_email' => $order_details[0]->user_email,
                          'user_id' => $order_details[0]->user_id,
                          'invoice_generated_date' => $todayDate,
                          'invoice_paid_date' => $todayDate,
                          'plan_apply_date'=> $todayDate,
                          'amount_paid' => $request->TXNAMOUNT,
                          'total_amount'=>$order_details[0]->total_amount,
                          'transaction_status' => $request->STATUS,
                          'payment_mode' => 'Online',
                          'payment_received' => 'Yes',
                          'property_uid' => $order_details[0]->property_uid,
                          'property_amount' => $order_details[0]->expected_rent,
                          'choose_payment_type' => $order_details[0]->choose_payment_type,
                          'payment_percentage' => $order_details[0]->payment_percentage
                       ];

                     invoices::updateOrCreate($exist_invoice, $invoice);
                   $invoice_letout=  invoices::where(['property_uid'=> $order_details[0]->property_uid,'plan_type'=>'Let Out'])->first();
                      if($invoice_letout && $invoice_letout->plan_name == 'Standard' && $order_details[0]->payment_percentage==100){

                          $letout_plan_details= DB::table('plans_orders')->where(['invoice_no'=> $invoice_letout->invoice_no])->first(); 
                          $sgst_amount = round((9 * $letout_plan_details->plan_price) / 100);
                          $cgst_amount = round((9 * $letout_plan_details->plan_price) / 100);
                          $total_amount_plan= round($letout_plan_details->plan_price + $sgst_amount+$cgst_amount);
                          invoices::where(['property_uid'=> $order_details[0]->property_uid,'plan_type'=>'Let Out','plan_name'=>'Standard'])->update(['property_amount'=>$letout_plan_details->expected_rent,'amount_paid'=>$total_amount_plan,'payment_status' => 'PAID','payment_mode'=>'Payment Paid by user','payment_received'=>'Yes','payment_status_change_reason'=>'Payment Received from Renter','transaction_status'=>'Cross_Payment','invoice_paid_date'=>$todayDate,'service_delivered_status'=>'Service Delivered','service_delivered_date'=>$todayDate]);
                          // DB::table('plans_orders')->where(['invoice_no'=> $letout_plan_details->invoice_no])->update(['transaction_status'=>'Cross_Payment','payment_status' => 'PAID','amount_paid'=>$total_amount_plan]);
                      }
                      
                      if($invoice_letout && ($invoice_letout->plan_name == 'Raja' || $invoice_letout->plan_name == 'MahaRaja')){
                          invoices::where(['property_uid'=> $order_details[0]->property_uid,'plan_type'=>'Let Out','payment_status'=>'PAID'])->update(['service_delivered_status'=>'Service Delivered','service_delivered_date'=>$todayDate]);
                      }

                     DB::table('invoices')->where(['property_uid'=> $order_details[0]->property_uid,'payment_status'=>'UNPAID','plan_type'=>'Rent'])->update(['property_status' => 'Property Rented to Another User']);  
                     DB::table('invoices')->where(['property_uid'=>  $order_details[0]->property_uid,'invoice_no'=> $invoice_id,'plan_type'=>'Rent'])->update(['property_status' => 'Property Rented','service_delivered_status'=>'Service Delivered','service_delivered_date'=>$todayDate]);
                                  
                      product::where('id', $order_details[0]->property_id)->update(['order_status' => '1']);
                      
                      UserProductCount::where('product_id', $order_details[0]->property_id)->update(['status' => '0']);
                   
                      /* Wishlist disabled by ID */
                      Wishlist::where('product_id', $order_details[0]->property_id)->update(['status' => '0']);
                        /* Product comparison disabled by ID */
                      Product_Comparision::where('product_id', $order_details[0]->property_id)->update(['status' => '0']);
                      
                      $angular_url = env('angular_url').'invoice?'.'invoice_no='.$invoice_id;

                     }
                     if($order_details[0]->choose_payment_type=='book_property'){
                       $exist_invoice= [
                        'invoice_no' => $invoice_id
                      ];

                      $invoice =[
                          'invoice_no' => $invoice_id,
                          'plan_name' => $order_details[0]->plan_name,
                          'plan_id' => $order_details[0]->plan_id,
                          'plan_type' => $order_details[0]->plan_type,
                          'payment_type' => $order_details[0]->payment_type,
                          'order_id' => $order_details[0]->order_id,
                          'expected_rent' => $order_details[0]->expected_rent,
                          'plan_price' => $order_details[0]->plan_price,

                         'agreement_price' =>$order_details[0]->agreement_price,
                          'payment_status' => 'PAID',
                          'plan_status'=>'used',
                          'user_email' => $order_details[0]->user_email,
                          'user_id' => $order_details[0]->user_id,
                          'invoice_generated_date' => $todayDate,
                          'invoice_paid_date' => $todayDate,
                          'plan_apply_date'=> $todayDate,
                          'amount_paid' => $request->TXNAMOUNT,
                          'total_amount'=>$order_details[0]->total_amount,
                          'transaction_status' => $request->STATUS,
                          'payment_mode' => 'Online',
                          'payment_received' => 'Yes',
                          'property_uid' => $order_details[0]->property_uid,
                          'property_amount' => $order_details[0]->expected_rent,
                          'choose_payment_type' => $order_details[0]->choose_payment_type,
                          'payment_percentage' => $order_details[0]->payment_percentage
                       ];

                     invoices::updateOrCreate($exist_invoice, $invoice);
                     // second invoice 
                       $year2 = Carbon::now()->format('y');
                        $month2 = Carbon::now()->format('m');
                        $day2 = Carbon::now()->format('d');
                        $hour2 = Carbon::now()->format('h');
                        $minute2 = Carbon::now()->format('i');
                        $second2 = Carbon::now()->format('s');
                        $x=2;

                     $main_invoice_id = 'INV' . $year2 . $month2 . $day . $hour2 . $minute2 . $second2 . $x;
                     $book_order_id=$order_details[0]->order_id . '-' .rand(1,9);
                     $main_invoice =[
                          'invoice_no' => $main_invoice_id,
                          'plan_name' => $order_details[0]->plan_name,
                          'plan_id' => $order_details[0]->plan_id,
                          'plan_type' => $order_details[0]->plan_type,
                          'payment_type' => $order_details[0]->payment_type,
                          'order_id' => $order_details[0]->order_id,
                          'expected_rent' => $order_details[0]->expected_rent,
                          'plan_price' => $order_details[0]->plan_price,

                          'agreement_price' =>$order_details[0]->agreement_price,
                          'payment_status' => 'UNPAID',
                          'total_amount'=>$order_details[0]->total_amount,
                          
                        'amount_paid'=>$order_details[0]->total_amount- $order_details[0]->amount_paid,
                          'plan_status'=>'used',
                          'user_email' => $order_details[0]->user_email,
                          'user_id' => $order_details[0]->user_id,
                          'invoice_generated_date' => $todayDate,
                          'payment_mode' => 'Cash',
                          'choose_payment_type' =>'book_property_after_payment',
                          'payment_percentage' =>100- $order_details[0]->payment_percentage,
                          'plan_apply_date'=> $todayDate,
                          'payment_received' => 'Pending',
                          'property_uid' => $order_details[0]->property_uid,
                          'property_amount' => $order_details[0]->expected_rent,
                          'book_order_id'=>$book_order_id 
                       ];

                     invoices::Create($main_invoice);
                   plansRentOrders::where('order_id',$order_details[0]->order_id)->update(['book_order_id' => $book_order_id]); 

                     DB::table('invoices')->where(['property_uid'=> $order_details[0]->property_uid,'payment_status'=>'UNPAID','plan_type'=>'Rent'])->update(['property_status' => 'Property Booked to Another User']);  
                     DB::table('invoices')->where(['property_uid'=>  $order_details[0]->property_uid,'invoice_no'=> $invoice_id])->update(['property_status' => 'Property Book']);
                     
                     DB::table('invoices')->where(['property_uid'=>  $order_details[0]->property_uid,'invoice_no'=> $main_invoice_id])->update(['property_status' => 'Property Book']);


                    product::where('id', $order_details[0]->property_id)->update(['order_status' => '2']);
                      
                      UserProductCount::where('product_id', $order_details[0]->property_id)->update(['status' => '0']);
                   
                      /* Wishlist disabled by ID */
                      Wishlist::where('product_id', $order_details[0]->property_id)->delete();
                        /* Product comparison disabled by ID */
                      Product_Comparision::where('product_id', $order_details[0]->property_id)->delete();
                      
                      $angular_url = env('angular_url').'book-property?'.'invoice_no='.$invoice_id;
                     }
                }

                return response()->redirectTo($angular_url); 
                
            }
            else {

                $order_details = plansRentOrders::where('order_id', $request->ORDERID)->first();
                plansRentOrders::where('order_id', $request->ORDERID)->update(['payment_status' => 'FAIL']);
                $angular_url = env('angular_url').'payment-fail';
            return response()->redirectTo($angular_url);  
            }
               
        }
        catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

 public function PlansRentPostPaymentRemaining(Request $request) {
        try {   
            $plan_transaction= [
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
            
            $exist_order= [
                'order_id' =>$request->ORDERID
              ];            
            plansTransaction::updateOrCreate($exist_order, $plan_transaction);

            // transaction status update
            plansRentOrders::where('book_order_id', $request->ORDERID)->update(['transaction_status' => $request->STATUS]);

            if($request->STATUS == 'TXN_SUCCESS') {

                $invoice_details = invoices::where('book_order_id', $request->ORDERID)->orderBy('id','desc')->first();

                $user_email = $invoice_details->user_email;

                $todayDate = Carbon::now()->format('Y-m-d H:i:s');

                $invoice_letout=  invoices::where(['property_uid'=> $invoice_details->property_uid,'plan_type'=>'Let Out'])->first();

             invoices::where(['property_uid'=> $invoice_details->property_uid,'invoice_no'=> $invoice_details->invoice_no])->update(['transaction_status'=>'TXN_SUCCESS','payment_mode'=>'Online','payment_received'=>'Yes','payment_status'=>'PAID','amount_paid'=>$request->TXNAMOUNT]);

                 if($invoice_letout && $invoice_letout->plan_name == 'Standard'){

                          $letout_plan_details= DB::table('plans_orders')->where(['invoice_no'=> $invoice_letout->invoice_no])->first(); 
                          $sgst_amount = round((9 * $letout_plan_details->plan_price) / 100);
                          $cgst_amount = round((9 * $letout_plan_details->plan_price) / 100);
                          $total_amount_plan= round($letout_plan_details->plan_price + $sgst_amount+$cgst_amount);
                          invoices::where(['property_uid'=> $invoice_details->property_uid,'plan_type'=>'Let Out','plan_name'=>'Standard'])->update(['property_amount'=>$letout_plan_details->expected_rent,'amount_paid'=>$total_amount_plan,'payment_status' => 'PAID','payment_mode'=>'Payment Paid by user','payment_received'=>'Yes','payment_status_change_reason'=>'Payment Received from Renter','transaction_status'=>'Cross_Payment','invoice_paid_date'=>$todayDate,'service_delivered_status'=>'Service Delivered','service_delivered_date'=>$todayDate]);
                      }
                      
                      if($invoice_letout && ($invoice_letout->plan_name == 'Raja' || $invoice_letout->plan_name == 'MahaRaja')){
                          invoices::where(['property_uid'=> $invoice_details->property_uid,'plan_type'=>'Let Out','payment_status'=>'PAID'])->update(['service_delivered_status'=>'Service Delivered','service_delivered_date'=>$todayDate]);
                      }

                     DB::table('invoices')->where(['property_uid'=> $invoice_details->property_uid,'payment_status'=>'UNPAID'])->update(['property_status' => 'Property Rented to Another User']);

                     DB::table('invoices')->where(['order_id'=>  $invoice_details->order_id,'book_order_id'=>NULL])->update(['property_status' => 'Property Rented','service_delivered_status'=>'Service Delivered','service_delivered_date'=>$todayDate,'invoice_paid_date'=>$todayDate]);  
                     DB::table('invoices')->where(['property_uid'=>  $invoice_details->property_uid,'invoice_no'=> $invoice_details->invoice_no])->update(['property_status' => 'Property Rented','payment_status_change_reason'=>NULL,'service_delivered_status'=>'Service Delivered','service_delivered_date'=>$todayDate,'invoice_paid_date'=>$todayDate]);
                                  
                      product::where('product_uid', $invoice_details->property_uid)->update(['order_status' => '1']);

                     $property_data= product::where('product_uid', $invoice_details->property_uid)->first();
                      
                      UserProductCount::where('product_id', $property_data->id)->delete();
                   
                      /* Wishlist disabled by ID */
                      Wishlist::where('product_id',$property_data->id)->delete();
                        /* Product comparison disabled by ID */
                      Product_Comparision::where('product_id', $property_data->id)->delete();
                      
                    
                $angular_url = env('angular_url').'my-properties';
               return response()->redirectTo($angular_url); 
                
            }
            else {
                plansRentOrders::where('order_id', $request->ORDERID)->update(['payment_status' => 'FAIL']);
                $angular_url = env('angular_url').'my-properties';
               return response()->redirectTo($angular_url); 
            } 
               
        }
        catch (\Exception $e) {
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
