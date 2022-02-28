<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentPlans;
use App\Models\LetOutPlans;
use App\Models\plansOrders;
use App\Models\plansRentOrders;
use DB;
use Auth;
use App\Models\planCredit;
use Carbon\Carbon;
use App\Models\invoices;
use App\Models\product;
use App\Models\LetOutPlansNew;
use App\Models\PropertyPlans;
use App\Models\plansFeaturesPivot;
use App\Models\orderPlanFeatures; 
use App\Models\Wishlist;
use App\Models\Product_Comparision;
use App\Http\Controllers\Api\Authicationcheck;
use App\Models\UserProductCount;

class PlansController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_enabled_rent_plans() {
        $rent_plans = DB::table('property_plans')->where(['plan_type' => 'Rent','plan_status'=> 'enabled'])->get();
        return response()->json([
            'data' => $rent_plans
        ], 200);
    }

    public function get_enabled_letout_plans() {
        $letout_plans = DB::table('property_plans')->where(['plan_type' => 'Let Out','plan_status'=> 'enabled'])->get();
        return response()->json([
            'data' => $letout_plans
        ], 200);
    }

    public function get_all_rent_plans() {
        $rent_plans = DB::table('property_plans')->where(['plan_type' => 'Rent'])->get();
        return response()->json([
            'data' => $rent_plans
        ], 200);
    }

    public function get_all_letout_plans() {
        $letout_plans = DB::table('property_plans')->where(['plan_type' => 'Let Out'])->get();
        return response()->json([
            'data' => $letout_plans
        ], 200);
    }

    public function getLetOutPlans_Features() {
         $letout_plans = DB::table('let_out_plans')->get();

         $letout_features = DB::table('let_out_features')->orderBy('id')->select(DB::raw('feature_name, group_concat(feature_details) as feature_details'))->groupBy('feature_name')->get();
         return response()->json([
            'letout_plans' =>$letout_plans,
            'letout_features' =>$letout_features,
          ], 201);

    }
    

    public function get_rent_features() {
        //return $rent_features = DB::table('rent_features')->groupBy('feature_name')->get();
        //return $rent_features = DB::table('rent_features')->select(DB::raw('feature_name, group_concat(feature_details) as feature_details'))->groupBy('feature_name')->get();
        //return $rent_features = DB::table('rent_features')->orderBy('feature_id')->select(DB::raw('feature_name, group_concat(feature_details) as feature_details'))->groupBy('feature_name')->get();
        //return $rent_features = DB::table('rent_plans')->where('status', 'enabled')->join('rent_features', 'rent_plans.plan_ID','=','rent_features.plan_id')->orderBy('feature_id')->select(DB::raw('feature_name, group_concat(feature_details) as feature_details'))->groupBy('feature_name')->get();
        $plan_details = PropertyPlans::where(['plan_type' => 'Rent','plan_status'=> 'enabled'])->with('features')->get();
        return $plan_details;
    }

    public function get_letout_features() {
        $plan_details = PropertyPlans::where(['plan_type' => 'Let Out','plan_status'=> 'enabled'])->with('features')->get();
        return $plan_details;
    }

    public function user_plan_availability()
    {
        try{
            $user_id = Auth::user()->id;
            $data=invoices::where([['user_id','=',$user_id],['plan_name','!=','Standard'],['payment_status','=','PAID']])->get();
                return response()->json([
                    'data' => $data
                ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
      } 
    }

    public function post_selected_plan(Request $request) {
        // return $request->plan_features_data['features']['4']['feature_value'];
        $data = json_decode($request->plan_features_data, true);
    
        $request->validate([
            'user_id' => 'required',
            'user_email' => 'required',
            'plan_type' => 'required',
			'plan_name' => 'required',
            'expected_rent' => 'required',
            'plan_id' => 'required',
            'payment_type' => 'required',
            'plan_price' => 'required'
        ]);

        $order_id = 'OR'.rand (10,100).time();

        if($request->plan_type == 'Let Out') {
            $plan = new plansOrders([
                'user_id' => $request->user_id,
                'user_email' => $request->user_email,
                'order_id' => $order_id,
                'plan_type' => $request->plan_type,
                'plan_name' => $request->plan_name,
                'plan_id' => $request->plan_id,
                'expected_rent' => $request->expected_rent,
                'plan_price' => $request->plan_price,
                'payment_type' => $request->payment_type
                
            ]);

            $plan_features = new orderPlanFeatures([
                'order_id' => $order_id,
                'plan_id' => $data['id'],
                'plan_name' => $data['plan_name'],
                'plan_type' => $data['plan_type'],
                'plan_status' => $data['plan_status'],
                'payment_type' => $data['payment_type'],
                'special_tag' => $data['special_tag'],
                'actual_price_days' => $data['actual_price_days'],
                'discount_status' => $data['discount'],
                'discounted_price_days' => $data['discounted_price_days'],
                'discount_percentage' => $data['discount_percentage'],
                'client_visit_priority'=>$data['features']['5']['feature_value'],
                'product_plans_days'=>$data['features']['4']['feature_value'],
                'plan_created_at' => $data['created_at'],
                'plan_updated_at' => $data['updated_at'],
                'features' => json_encode($data['features'])
            ]);
        }

        else if($request->plan_type == 'Rent') {
            $plan = new plansRentOrders([
                'user_id' => $request->user_id,
                'user_email' => $request->user_email,
                'order_id' => $order_id,
                'plan_type' => $request->plan_type,
                'plan_name' => $request->plan_name,
                'plan_id' => $request->plan_id,
                'expected_rent' => $request->expected_rent,
                'plan_price' => $request->plan_price,
                'payment_type' => $request->payment_type
                
            ]);

            $plan_features = new orderPlanFeatures([
                'order_id' => $order_id,
                'plan_id' => $data['id'],
                'plan_name' => $data['plan_name'],
                'plan_type' => $data['plan_type'],
                'plan_status' => $data['plan_status'],
                'payment_type' => $data['payment_type'],
                'special_tag' => $data['special_tag'],
                'actual_price_days' => $data['actual_price_days'],
                'discount_status' => $data['discount'],
                'discounted_price_days' => $data['discounted_price_days'],
                'discount_percentage' => $data['discount_percentage'],
                'plan_created_at' => $data['created_at'],
                'plan_updated_at' => $data['updated_at'],
                'features' => json_encode($data['features'])
            ]);
        }

            $plan->save();
            $plan_features->save();

            return response()->json([
                'data' => $plan,
                'message' => 'Successfully created Plan Order'
            ], 201);
    }

    public function post_selected_rent_plan(Request $request) {
        $data = json_decode($request->plan_features_data, true);

        $request->validate([
            'user_id' => 'required',
            'user_email' => 'required',
            'plan_type' => 'required',
			'plan_name' => 'required',
            'expected_rent' => 'required',
            'plan_id' => 'required',
            'payment_type' => 'required',
            'plan_price' => 'required',
            'property_id' => 'required',
            'property_name' => 'required',
            'gst_amount' => 'required',
            'security_deposit' => 'required',
            'total_amount' => 'required',
            'property_uid' => 'required',
            'payment_mode' => 'required'
        ]);

        $order_id = 'OR'.rand (10,100).time();

        $plan_features = new orderPlanFeatures([
            'order_id' => $order_id,
            'plan_id' => $data['id'],
            'plan_name' => $data['plan_name'],
            'plan_type' => $data['plan_type'],
            'plan_status' => $data['plan_status'],
            'payment_type' => $data['payment_type'],
            'special_tag' => $data['special_tag'],
            'actual_price_days' => $data['actual_price_days'],
            'discount_status' => $data['discount'],
            'discounted_price_days' => $data['discounted_price_days'],
            'discount_percentage' => $data['discount_percentage'],
            'plan_created_at' => $data['created_at'],
            'plan_updated_at' => $data['updated_at'],
            'features' => json_encode($data['features'])
        ]);

            $plan = new plansRentOrders([
                'user_id' => $request->user_id,
                'user_email' => $request->user_email,
                'order_id' => $order_id,
                'plan_type' => $request->plan_type,
                'plan_name' => $request->plan_name,
                'plan_id' => $request->plan_id,
                'expected_rent' => $request->expected_rent,
                'plan_price' => $request->plan_price,
                'payment_type' => $request->payment_type,
                'property_id' => $request->property_id,
                'property_name' => $request->property_name,
                'gst_amount' => $request->gst_amount,
                'maintenance_charge' => $request->maintenance_charge,
                'security_deposit' => $request->security_deposit,
                'total_amount' => $request->total_amount,
                'property_uid' => $request->property_uid,
                'payment_mode' => $request->payment_mode
            ]);

            $plan->save();
            $plan_features->save();

            return response()->json([
                'data' => $plan,
                'message' => 'Successfully created Rent Plan Order'
            ], 201);
    }

    public function get_order_details($orderID) {
         // $orderID = $request->input('orderID');
        return $order_details = DB::table('plans_orders')->where('order_id', $orderID)->get();
    }

    public function get_rent_order_details($orderID) {
        return $order_details = DB::table('plans_rent_orders')->where('order_id', $orderID)->get();
    }

    public function get_invoice_details($invoiceID) {
        try{
            $data =invoices::with('UserDetail','property_status')->where([
                ['invoice_no', $invoiceID]])->first();
            return response()->json([
                'data' =>$data,
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }


    public function rent_property_slip(Request $request) {
        $request->validate([
               'property_id' => 'required',
           ]);
       try{
           $token  = $request->header('authorization');
           $object = new Authicationcheck();
           if($object->authication_check($token) == true){
                $productID = $request->property_id;
              $data= product::with('property_invoice')->where('id', $productID)->first();
               return response()->json([
                   'data' =>$data,
                 ], 200);
           }
       }catch(\Exception $e) {
           return $this->getExceptionResponse($e);
       }  
   } 

    public function cancelled_deal(Request $request) {
         $request->validate([
                'invoice_no' => 'required',
                'payment_status_change_reason'=>'required'
            ]);
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){

                $invoice_data =invoices::where(['invoice_no'=> $request->invoice_no,'payment_received'=>'Yes'])->first();
                if($invoice_data){
                         if($invoice_data->plan_type == 'Let Out'){
                             if($invoice_data->payment_type == 'Advance'){
                            DB::table('plans_orders')->where(['invoice_no'=>$invoice_data->invoice_no])->update(['payment_status'=>'RETURN']);
                            $invoices_update =invoices::where(['invoice_no'=>$invoice_data->invoice_no])->update(['payment_status'=>'RETURN','payment_status_change_reason'=>$request->payment_status_change_reason]);
                            
                            if($invoice_data->property_uid){

                               $product_data= product::where('product_uid', $invoice_data ->property_uid)->first();

                            product::where('id', $product_data->id)->update(['order_status' => '0','enabled'=>'no','delete_flag'=>'0']);
                                UserProductCount::where('product_id',$product_data->id)->delete();
                                        /* Wishlist disabled by ID */
                                Wishlist::where('product_id', $product_data->id)->delete();
                                          /* Product comparison disabled by ID */
                                Product_Comparision::where('product_id',$product_data->id)->delete();
                            }


                                return response()->json([
                                     'message' =>'SUCCESS',
                                     'description' => 'Letout Invoice details RETURN',
                                     'status'=>200
                                 ], 200);

                            
                            }elseif($invoice_data->payment_type == 'Post'){
                                     DB::table('plans_orders')->where(['invoice_no'=>$invoice_data->invoice_no])->update(['payment_status'=>'CANCLE']);
                                $invoices_update =invoices::where(['invoice_no'=>$invoice_data->invoice_no])->update(['payment_status'=>'CANCLE','payment_status_change_reason'=>$request->payment_status_change_reason]);
                                
                                if($invoice_data->property_uid){
                                    
                                   $product_data= product::where('product_uid', $invoice_data ->property_uid)->first();

                                product::where('id', $product_data->id)->update(['order_status' => '0','enabled'=>'no','delete_flag' => '0']);
                                    UserProductCount::where('product_id',$product_data->id)->delete();
                                            /* Wishlist disabled by ID */
                                    Wishlist::where('product_id', $product_data->id)->delete();
                                              /* Product comparison disabled by ID */
                                    Product_Comparision::where('product_id',$product_data->id)->delete();
                                }

                                return response()->json([
                                     'message' =>'SUCCESS',
                                     'description' => 'Letout Invoice details CANCLE',
                                     'status'=>200
                                 ], 200);
                            }

                        }elseif($invoice_data->plan_type == 'Rent'){

                            DB::table('plans_rent_orders')->where(['invoice_no'=>$invoice_data->invoice_no])->update(['property_status' => 'Property  deals cancelled','payment_status'=>'RETURN']);
                            $invoices_update =invoices::where(['invoice_no'=>$invoice_data->invoice_no])->update(['payment_status'=>'RETURN','payment_status_change_reason'=>$request->payment_status_change_reason]);
                            
                            if($invoice_data->property_uid){

                               $product_data= product::where('product_uid', $invoice_data ->property_uid)->first();

                            product::where('id', $product_data->id)->update(['order_status' => '0','enabled'=>'Yes','delete_flag'=>'0']);
                                UserProductCount::where('product_id',$product_data->id)->delete();
                                        /* Wishlist disabled by ID */
                                Wishlist::where('product_id', $product_data->id)->delete();
                                          /* Product comparison disabled by ID */
                                Product_Comparision::where('product_id',$product_data->id)->delete();
                            }


                                return response()->json([
                                     'message' =>'SUCCESS',
                                     'description' => 'Renting Invoice details RETURN',
                                     'status'=>200
                                 ], 200);                    
                        }

                }else{
                     return response()->json([
                         'message' =>'FAIL',
                         'description' => 'Invoice details is Invalid !!!...',
                         'status'=>201
                     ], 201);
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

    public function invoice_status_change(Request $request) {
         $request->validate([
                'invoice_no' => 'required',
            ]);
         try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $order_details = DB::table('plans_rent_orders')->where('invoice_no', $request->invoice_no)->first();
                // return $order_details;
                if($order_details){
                    if($order_details->payment_status == 'UNPAID'){
                         DB::table('plans_rent_orders')->where(['property_uid'=> $order_details->property_uid,'payment_status'=>'UNPAID'])->update(['property_status' => 'Property Rented to Another User','payment_status'=>'CANCLE']);                  
                         plansRentOrders::where(['property_uid'=>$order_details->property_uid,'invoice_no'=>$request->invoice_no])->update(['payment_status' => 'PAID','property_status' => 'Property Rented','payment_received'=>'Yes','transaction_status'=>'TXN_SUCCESS','amount_paid'=>$order_details->total_amount]);

                         // invoice table  
                         $todayDate = Carbon::now()->format('Y-m-d');  

                        $invoices_data =invoices::where(['invoice_no'=>$request->invoice_no])->update(['invoice_paid_date' => $todayDate,'amount_paid' => $order_details->total_amount,'property_amount'=> $order_details->expected_rent,'payment_status'=>'PAID','payment_received'=>'Yes','transaction_status'=>'TXN_SUCCESS','property_uid'=>$order_details->property_uid]);
                        if($invoices_data){

                          product::where('id', $order_details->property_id)->update(['order_status' => '1']);
                          UserProductCount::where('product_id', $order_details->property_id)->update(['status' => '0']);
                        /* Wishlist disabled by ID */
                        Wishlist::where('product_id', $order_details->property_id)->update(['status' => '0']);
                          /* Product comparison disabled by ID */
                        Product_Comparision::where('product_id', $order_details->property_id)->update(['status' => '0']);

                            return response()->json([
                                 'message' =>'SUCCESS',
                                 'description' => 'Invoice Successfully Paid',
                                 'status'=>200
                             ], 200);
                        }else{
                                return response()->json([
                                     'message' =>'FAIL',
                                     'description' => 'Invoice details not Updated !!!...',
                                     'status'=>200
                                 ], 200);
                        }
                    
                    }else{

                    return response()->json([
                         'message' =>'SUCCESS',
                         'description' => 'Invoice Already Paid',
                         'status'=>200
                     ], 200);

                    }
                }else{
                    return response()->json([
                         'message' =>'FAIL',
                         'description' => 'Invoice details is Invalid !!!...',
                         'status'=>201
                     ], 201);

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

    public function product_invoice_Details(request $request) {
        $productID = $request->input('productID');
        $invoiceID = $request->input('invoiceID');
       $order_details = DB::table('invoices')->where('invoice_no', $invoiceID)->first();

       $property_details = DB::table('products')->where('product_uid', $productID)->first();
        return response()->json([
            'order_details' =>$order_details,
            'property_details' =>$property_details,
          ], 201);
    }
    public function get_user_invoices($emailID) {
        return $invoice_details = DB::table('invoices')->where([
            ['user_email', $emailID],
            ['plan_status', 'available'],
            ['plan_type', 'Let Out']
        ])->get();
    }

    public function get_plan_by_user(Request $request) {
      $request->validate([
                'user_id' => 'required|integer',
            ]);

        $user_id = $request->input('user_id');

      try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $data =invoices::where(['user_id'=> $user_id,'plan_type'=> 'Let Out','payment_status'=>'PAID'])->get();
                return response()->json([
                    'data' =>$data,
                ], 200);

            }else{
                return response() -> json([
                    'message' => 'FAIL',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            } 

      }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }

    public function get_all_user_invoices($emailID) {
        
      try{
            $data =invoices::with('productDetails')->where([
                ['user_email', $emailID]])->get();
            return response()->json([
                'data' =>$data,
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }

    public function get_credit_details($email) {
        return $credit_details = DB::table('plan_credits')->where('user_email', $email)->get();
    }

    public function get_total_credit($email) {
        return $credit_details = DB::table('total_credits')->where('user_email', $email)->get();
    }

    public function get_property_details($productID) {
        return $property_details = DB::table('products')->where('product_uid', $productID)->get();
    }

    public function update_property_details($productID) {
        product::where('product_uid', $productID)->update(['enabled' => 'yes']);

        return response()->json([
            'message' => 'Product details updated'
        ], 201);
    }

    public function update_invoice_details(Request $request) {

        product::where('product_uid', $request->product_id)->update(['enabled' => 'yes']);   
        invoices::where('invoice_no', $request->invoice_id)->update(['plan_status' => 'used', 'property_uid' => $request->product_id, 'property_amount' => $request->product_price]);     
        return response()->json([
            'message' => 'Invoice details updated'
        ], 201);
    }

    public function property_live_bycrm(Request $request) {
         $request->validate([
                'invoice_no' => 'required',
                'property_uid' => 'required|integer'
            ]);

         try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $product_price = product::select('expected_rent')->where('product_uid', $request->property_uid)->first();
                
                product::where('product_uid', $request->property_uid)->update(['enabled' => 'yes']);   
                invoices::where('invoice_no', $request->invoice_no)->update(['plan_status' => 'used', 'property_uid' => $request->property_uid,'property_amount' => $product_price->expected_rent]);     
                return response()->json([
                    'message' =>'SUCCESS',
                     'description' => 'Property Successfully Lived',
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
            return $this->getExceptionResponse($e);
        }  

    }
    

    public function generate_invoice(Request $request) {
        try {

            $order_details = DB::table('plans_orders')->where('order_id', $request->orderID)->get();
            $payment_type = $order_details[0]->payment_type;
    
            if($order_details[0]->invoice_no == NULL)
            {
                $year = Carbon::now()->format('y');
                $month = Carbon::now()->format('m');
                $day = Carbon::now()->format('d');
                $hour = Carbon::now()->format('h');
                $minute = Carbon::now()->format('i');
                $second = Carbon::now()->format('s');
                $invoice_id = 'INV' . $year . $month . $day . $hour . $minute . $second;
                plansOrders::where('order_id', $request->orderID)->update(['invoice_no' => $invoice_id, 'payment_status' => 'UNPAID']);
            }
            else {
                $invoice_id = $order_details[0]->invoice_no;
            }

            $credit = new planCredit([
                'user_id' => $order_details[0]->user_id,
                'user_email' => $order_details[0]->user_email,
                'payment_status' => 'UNPAID',
                'credits' => $order_details[0]->expected_rent,
                'invoice_no' => $invoice_id
            ]);

            $credit->save();

            if($payment_type == 'Post') {

                $todayDate = Carbon::now()->format('Y-m-d');

                $invoice = new invoices([
                    'invoice_no' => $invoice_id,
                    'plan_name' => $order_details[0]->plan_name,
                    'plan_id' => $order_details[0]->plan_id,
                    'plan_type' => $order_details[0]->plan_type,
                    'payment_type' => $order_details[0]->payment_type,
                    'order_id' => $order_details[0]->order_id,
                    'expected_rent' => $order_details[0]->expected_rent,
                    'plan_price' => $order_details[0]->plan_price,
                    'payment_status' => 'UNPAID',
                    'user_email' => $order_details[0]->user_email,
                    'user_id' => $order_details[0]->user_id,
                    'invoice_generated_date' => $todayDate,
                    'payment_received' => 'No'  
                ]);

                $invoice->save();
                /*$total_credit = DB::table('total_credits')->where('user_email', $order_details[0]->user_email)->get();
            
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
                    totalCredits::where('user_email', $order_details[0]->user_email)->update(['total_credits' => $new_credit]);
                } */
            }
            else if ($payment_type == 'Advance') {
                $todayDate = Carbon::now()->format('Y-m-d');

                $invoice = new invoices([
                    'invoice_no' => $invoice_id,
                    'plan_name' => $order_details[0]->plan_name,
                    'plan_id' => $order_details[0]->plan_id,
                    'plan_type' => $order_details[0]->plan_type,
                    'payment_type' => $order_details[0]->payment_type,
                    'order_id' => $order_details[0]->order_id,
                    'expected_rent' => $order_details[0]->expected_rent,
                    'plan_price' => $order_details[0]->plan_price,
                    'payment_status' => 'UNPAID',
                    'user_email' => $order_details[0]->user_email,
                    'user_id' => $order_details[0]->user_id,
                    'invoice_generated_date' => $todayDate,
                    'payment_mode' => 'Cash',
                    'payment_received' => 'Pending'  
                ]);

                $invoice->save();
            }
            
            return response()->json([
                'data' => $invoice_id
            ], 201);
            
            }
        catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
        

    }

    public function generate_rent_invoice(Request $request) {
        try {

            $order_details = DB::table('plans_rent_orders')->where('order_id', $request->orderID)->get();
    
            if($order_details[0]->invoice_no == NULL)
            {
                $year = Carbon::now()->format('y');
                $month = Carbon::now()->format('m');
                $day = Carbon::now()->format('d');
                $hour = Carbon::now()->format('h');
                $minute = Carbon::now()->format('i');
                $second = Carbon::now()->format('s');
                $invoice_id = 'INV' . $year . $month . $day . $hour . $minute . $second;
                plansRentOrders::where('order_id', $request->orderID)->update(['invoice_no' => $invoice_id, 'payment_status' => 'UNPAID']);
            }
            else {
                $invoice_id = $order_details[0]->invoice_no;
            }

                $todayDate = Carbon::now()->format('Y-m-d');

                $invoice = new invoices([
                    'invoice_no' => $invoice_id,
                    'plan_name' => $order_details[0]->plan_name,
                    'plan_id' => $order_details[0]->plan_id,
                    'plan_type' => $order_details[0]->plan_type,
                    'payment_type' => $order_details[0]->payment_type,
                    'order_id' => $order_details[0]->order_id,
                    'expected_rent' => $order_details[0]->expected_rent,
                    'plan_price' => $order_details[0]->plan_price,
                    'payment_status' => 'UNPAID',
                    'user_email' => $order_details[0]->user_email,
                    'user_id' => $order_details[0]->user_id,
                    'invoice_generated_date' => $todayDate,
                    'payment_mode' => 'Cash',
                    'payment_received' => 'Pending'  
                ]);

                $invoice->save();
            
            
            return response()->json([
                'data' => $invoice_id
            ], 201);
            
            }
        catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
        
    }

    public function get_rented_properties($userEmail) {
       return $property_details = DB::table('plans_rent_orders')->where(['user_email' => $userEmail, 'transaction_status' => 'TXN_SUCCESS'])->get();
    }

    public function update_property_plans(Request $request) {
        try {
            $request->validate([
                'id' => 'required',
                'payment_type' => 'required|string',
                'plan_type' => 'required|string',
                'plan_name' => 'required|string',
                'plan_actual_price' => 'required|integer',
                'plan_status' => 'required|string',
                'special_tag' => 'required|string',
                'discount_status' => 'required|string',
                'discounted_price' => 'sometimes|nullable|integer',
                'discount_per' => 'sometimes|nullable|numeric'
            ]);

            PropertyPlans::where(['id' => $request->id])->update(['plan_name' => $request->plan_name, 'plan_type' => $request->plan_type, 
            'payment_type' => $request->payment_type, 'actual_price_days' => $request->plan_actual_price, 
            'discount' => $request->discount_status, 'discounted_price_days' => $request->discounted_price, 
            'discount_percentage' => $request->discount_per, 'special_tag' => $request->special_tag, 'plan_status' => $request->plan_status]);

            $plan = PropertyPlans::where(['id' => $request->id])->first();
            $plan->features()->detach();

            foreach($request->features as $feature => $value) {
                if($value == true) {
                    $feature_id[] = $feature;
                }
            }
            $plan->features()->attach($feature_id);
            
            return response()->json([
                'message' => 'Plan details updated'
            ], 201);
        }
        catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    public function add_property_plan(Request $request) {
        try {
            $validator = $request->validate([
                'plan_type' => 'required|string',
                'planName' => 'required|string',
                'actualPrice' => 'required|integer',
                'payment_type' => 'required|string',
                'plan_status' => 'required|string',
                'special_tag' => 'required|string',
                'discount_status' => 'required|string',
                'discountPrice' => 'sometimes|nullable|integer',
                'discount_per' => 'sometimes|nullable|numeric'
            ]);

            $plan = new PropertyPlans([
                'plan_type' => $request->plan_type,
                'plan_name' => $request->planName,
                'actual_price_days' => $request->actualPrice,
                'discount' => $request->discount_status,
                'discounted_price_days' => $request->discountPrice,
                'discount_percentage' => $request->discount_per,
                'payment_type' => $request->payment_type,
                'plan_status' => $request->plan_status,
                'special_tag' => $request->special_tag
            ]);

            $plan->save();

            foreach($request->features as $feature => $value) {
                if($value == true) {
                    $feature_id[] = $feature;
                }
            }

            //return $feature_id;
            $plan->features()->attach($feature_id);
            return response()->json([
                'message' => 'Plan Added Successfully'
            ], 201);
        }
        catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }

    }

    public function get_all_features() {
        try {
            $features = DB::table('plans_features')->get();
            return response()->json([
                'features' => $features
            ], 201);
        }
        catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    public function get_plan_features(Request $request) {
        try {
            
            $plan_features = DB::table('plans_features_pivots')->where('plan_id', $request->plan_id)->get();
            $features = DB::table('plans_features')->get();
            foreach($features as $f) {
                $f->status = false;
            }
            foreach($plan_features as $val) {
                foreach($features as $val1) {
                    if($val->feature_id == $val1->id) {
                        $val1->status = true;
                    }
                }
            }
            return $features;
        }
        catch (\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

}
