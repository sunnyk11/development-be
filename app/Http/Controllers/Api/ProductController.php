<?php

namespace App\Http\Controllers\Api;

use App\Models\product;
use App\Models\eventtracker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Image;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Wishlist;
use App\Models\Amenitie;
use App\Models\ProductAmenties;
use App\Models\UserProductCount;
use App\Models\Product_img;
use App\Models\area_locality;
use App\Models\Product_Comparision;
use App\Models\property_room_pivot;
use App\Models\invoices;
use Carbon\Carbon;
use App\Models\flat_type;
use Illuminate\Support\Facades\Input;
use App\Http\Resources\API\Product\ProductListResource;
use App\Http\Resources\API\crm_rentslip;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->with('UserDetail','product_img','Property_Type')->orderBy('id', 'desc')->get();
        return response()->json([
            'data' =>$data,
        ], 201);
    }

    public function admin_get_property_id(Request $request) {
      if($request->user_mobile){

         $user=User::whereNotNull('bank_type')->where('other_mobile_number',$request->user_mobile)->first();
         $data=product::select('id','product_uid','property_mode','user_id','crm_user_email','build_name','expected_pricing','expected_rent','order_status','payment_status')->where(['user_id'=>$user->id,'delete_flag'=> '0','draft'=> '0','enabled' => 'yes','payment_status'=>'0','order_status'=>'1'])->orderBy('id', 'desc')->get();
        return response()->json([
            'data' => $data,
            'user' =>$user
        ], 200);
      }if($request->user_id){
         $data=product::select('id','product_uid','property_mode','user_id','crm_user_email','build_name','expected_pricing','expected_rent','order_status','payment_status')->where(['user_id'=>$request->user_id,'delete_flag'=> '0','draft'=> '0','enabled' => 'yes','payment_status'=>'0','order_status'=>'1'])->orderBy('id', 'desc')->get();
         $user=User::whereNotNull('bank_type')->where('id', $request->user_id)->first();
        return response()->json([
            'data' => $data,
            'user' =>$user
        ], 200);

      }
       try{
       
       }catch(\Exception $e) {
        return $this->getExceptionResponse($e);
        }
   }
    public function admin_get_property(Request $request)
    {
      if($request->invoice_no){
       $invoice_details = invoices::select('property_uid','id')->with('propertyDetails')->where([['payment_status','!=','CANCEL'],['payment_status','!=','RETURN'],['invoice_no',$request->invoice_no]])->first();
       if($invoice_details){
       $data=product::select('id','product_uid','property_mode','user_id','crm_user_email','state_id','district_id','locality_id','sub_locality_id','build_name','expected_pricing','rent_availability','sale_availability','expected_rent','delete_flag','draft','enabled','order_status')->where(['delete_flag'=> '0','draft'=> '0', 'enabled' => 'yes','product_uid'=>$invoice_details->property_uid])->with('product_img','product_state','product_district','product_locality','product_sub_locality','letout_invoice','purchase_property','book_property')->orderBy('id', 'desc')->search($request)->paginate(5);

         return response()->json([
            'data' =>$data,
            'status' => '200'
        ], 200);

       }else{
        $data=null;
          return response()->json([
            'data' =>$data,
            'status' => '200'
        ], 200);

       }
      }else{
        $data = product::select('id','product_uid','property_mode','user_id','crm_user_email','state_id','district_id','locality_id','sub_locality_id','build_name','expected_pricing','rent_availability','sale_availability','expected_rent','delete_flag','draft','enabled','order_status')->where(['delete_flag'=> '0','draft'=> '0', 'enabled' => 'yes'])->with('product_img','product_state','product_district','product_locality','product_sub_locality','letout_invoice','purchase_property','book_property')->orderBy('id', 'desc')->search($request)->paginate(5);
        return response()->json([
            'data' =>$data,
            'status' => '200'
        ], 200);
      }
        
    }

    public function admin_get_property_excel(Request $request)
    {
      if($request->invoice_no){
       $invoice_details = invoices::select('property_uid','id')->with('propertyDetails')->where([['payment_status','!=','CANCEL'],['payment_status','!=','RETURN'],['invoice_no',$request->invoice_no]])->first();
       if($invoice_details){
       $data=product::select('id','product_uid','property_mode','user_id','crm_user_email','state_id','district_id','locality_id','sub_locality_id','build_name','expected_pricing','rent_availability','sale_availability','expected_rent','delete_flag','draft','enabled','order_status')->where(['delete_flag'=> '0','draft'=> '0', 'enabled' => 'yes','product_uid'=>$invoice_details->property_uid])->with('product_img','product_state','product_district','product_locality','product_sub_locality','letout_invoice','purchase_property','book_property')->orderBy('id', 'desc')->search($request)->get();

        $excel= ProductListResource::collection($data);
          return response()->json([
            'data' =>$excel,
            'status' => '200'
        ], 200);

        }else{
          $data=null;
          return response()->json([
            'data' =>$excel,
            'status' => '200'
        ], 200);

        }
      }else{
        $data = product::select('id','product_uid','property_mode','user_id','crm_user_email','state_id','district_id','locality_id','sub_locality_id','build_name','expected_pricing','rent_availability','sale_availability','expected_rent','delete_flag','draft','enabled','order_status')->where(['delete_flag'=> '0','draft'=> '0', 'enabled' => 'yes'])->with('product_img','product_state','product_district','product_locality','product_sub_locality','letout_invoice','rent_invoice')->orderBy('id', 'desc')->search($request)->get();
        $excel= ProductListResource::collection($data);
        return response()->json([
            'data'=>$excel,
            'status' => '200'
        ], 200);
      }
        
    }
    public function product_city_details()
    {

        $current_date= Carbon::now()->format('Y-m-d H:i:s');
     $chattarpur_id=area_locality::select('locality_id')->where(['locality' =>'CHATTARPUR','status' => '1'])->first();
     $Vasant_id=area_locality::select('locality_id')->where(['locality' =>'Vasant Kunj','status' => '1'])->first();
     // return $chattarpur_id;
     if($chattarpur_id){
        $Vasant=[];
     $locality_data=product::select('products.id as product_id','products.build_name','products.area','products.flat_type','products.available_for','products.furnishing_status','products.security_deposit','products.user_id','products.rent_availability','products.sale_availability','products.state_id','products.sub_locality_id','products.locality_id','products.sale_availability','products.type','products.expected_pricing','products.expected_rent','products.bedroom','products.area_unit','products.bathroom','invoices.plan_type','invoices.plan_name','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw('order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
            ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
            ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')
            ->where(['rent_availability'=>'1','delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes','invoices.plan_type'=>'Let Out','locality_id' =>$chattarpur_id['locality_id']])
            ->where([['invoices.payment_status','!=','CANCEL'],['invoices.payment_status','!=','RETURN'],['invoices.payment_status','!=','Payment Returned']])
           ->orderBy('plans_day_left','asc')
            ->get();
      $Chattarpur_data = $locality_data->groupBy('locality_id')->map(function ($row) {return $row->count();});
      $chattarpur=[];
      if(count($Chattarpur_data)>0){
        $chattarpur_array=['city'=>'CHATTARPUR','chattarpur_count'=>$Chattarpur_data['1281']];
         array_push($chattarpur,$chattarpur_array);
    }
    // all data for delhi location 
        $product_data=product::select('products.id as product_id','products.build_name','products.area','products.flat_type','products.available_for','products.furnishing_status','products.security_deposit','products.user_id','products.rent_availability','products.sale_availability','products.state_id','products.sub_locality_id','products.locality_id','products.sale_availability','products.type','products.expected_pricing','products.expected_rent','products.bedroom','products.area_unit','products.bathroom','invoices.plan_type','invoices.plan_name','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw('order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
            ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
            ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')
            ->where(['rent_availability'=>'1','delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes','invoices.plan_type'=>'Let Out'])
            ->where([['invoices.payment_status','!=','CANCEL'],['invoices.payment_status','!=','RETURN'],['invoices.payment_status','!=','Payment Returned']])
            ->whereNotNull('products.state_id')
           ->orderBy('plans_day_left','asc')
            ->get();


            if($Vasant_id){
                $locality_data1=product::select('products.id as product_id','products.build_name','products.area','products.flat_type','products.available_for','products.furnishing_status','products.security_deposit','products.user_id','products.rent_availability','products.sale_availability','products.state_id','products.sub_locality_id','products.locality_id','products.sale_availability','products.type','products.expected_pricing','products.expected_rent','products.bedroom','products.area_unit','products.bathroom','invoices.plan_type','invoices.plan_name','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw('order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
                ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
                ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')
                ->where(['rent_availability'=>'1','delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes','invoices.plan_type'=>'Let Out','locality_id' =>$Vasant_id['locality_id']])
                ->where([['invoices.payment_status','!=','CANCEL'],['invoices.payment_status','!=','RETURN'],['invoices.payment_status','!=','Payment Returned']])
               ->orderBy('plans_day_left','asc')
                ->get();
                    $Vasant_data = $locality_data1->groupBy('locality_id')->map(function ($row) {return $row->count();});
                   
                    if(count($Vasant_data)>0){
                        $Vasant_array=['city'=>'Vasant Kunj','Vasant_count'=>$Vasant_data['1781']];
                        array_push($Vasant,$Vasant_array);
                    }
            }


      // return $product_data; 
        $grouped = $product_data->groupBy('state_id')->map(function ($row) {return $row->count();});
       $data=product::select('id','state_id')->where(['state_id'=> 1,'delete_flag'=> '0','rent_availability'=>'1','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->groupBy('state_id')->havingRaw('COUNT(*) > 0')->orderBy('id', 'asc')->get(); 

        $city_data=[];
        foreach ($data as $key => $value) {
            $city_count= $grouped[$value['state_id']];
                $count=['id'=>$value['id'],'city'=>'DELHI','city_count'=>$city_count];
                array_push($city_data,$count);
        }
        return response()->json([
            'data'=>$city_data,
            'Chattarpur_data'=> $chattarpur,
            'Vasant_data'=> $Vasant 
        ], 200);
     }else{
      $city_data=[];
      $chattarpur=[];
        return response()->json([
            'data'=>$city_data,
            'Chattarpur_data'=> $chattarpur 
        ], 200);
     }
    }

    public function product_category_details()
    {
        $product_data=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 
        $grouped = $product_data->groupBy('type')->map(function ($row) {return $row->count();});

      $data=product::select('id','type')->with('Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->groupBy('type')->havingRaw('COUNT(*) > 0')->orderBy('id', 'asc')->get(); 
// return $data;
        $category_data=[];
        foreach ($data as $key => $value) {
            $category_count= $grouped[$value['type']];
                $count=['id'=>$value['id'],'category'=>$value,'category_count'=>$category_count];
                array_push($category_data,$count);
        }


        $product_flat_type=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 
        $grouped = $product_flat_type->groupBy('flat_type')->map(function ($row) {return $row->count();});

      $flat_type_data=product::select('id','flat_type')->with('pro_flat_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->whereNotNull('flat_type')->groupBy('flat_type')->havingRaw('COUNT(*) > 0')->orderBy('id', 'asc')->get(); 
        $flat_type_data_fetch=[];
        foreach ($flat_type_data as $key => $flat_type_value) {
            $flat_type_count= $grouped[$flat_type_value['flat_type']];
            $count_flat_type=['id'=>$flat_type_value['id'],'flat_type'=>$flat_type_value,'flat_type_count'=>$flat_type_count];
                array_push($flat_type_data_fetch,$count_flat_type);
        }
        return response()->json([
            'data'=>$category_data,
            'flat_type'=> $flat_type_data_fetch,
        ], 200);
    }

    public function web_dropdown_data()
    {
        $product_data=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 
        $grouped = $product_data->groupBy('type')->map(function ($row) {return $row->count();});

      $data=product::select('id','type')->with('Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->groupBy('type')->havingRaw('COUNT(*) > 0')->orderBy('id', 'asc')->get(); 
// return $data;
        $category_data=[];
        foreach ($data as $key => $value) {
            $category_count= $grouped[$value['type']];
                $count=['id'=>$value['id'],'category'=>$value,'category_count'=>$category_count];
                array_push($category_data,$count);
        }
 // flat_type
        $product_flat_type=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 
        $grouped = $product_flat_type->groupBy('flat_type')->map(function ($row) {return $row->count();});

      $flat_type_data=product::select('id','flat_type')->with('pro_flat_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->whereNotNull('flat_type')->groupBy('flat_type')->havingRaw('COUNT(*) > 0')->orderBy('id', 'asc')->get(); 
        $flat_type_data_fetch=[];
        foreach ($flat_type_data as $key => $flat_type_value) {
            $flat_type_count= $grouped[$flat_type_value['flat_type']];
            $count_flat_type=['id'=>$flat_type_value['id'],'flat_type'=>$flat_type_value,'flat_type_count'=>$flat_type_count];
                array_push($flat_type_data_fetch,$count_flat_type);
        }

        // security data
         $product_security=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 

        $grouped = $product_security->groupBy('security_deposit')->map(function ($row) {return $row->count();});

      $security_deposit_data=product::select('id','security_deposit')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->whereNotNull('security_deposit')->groupBy('security_deposit')->havingRaw('COUNT(*) > 0')->orderBy('security_deposit', 'asc')->get(); 
        $security_deposit_data_fetch=[];
        foreach ($security_deposit_data as $key => $security_deposit_value) {
            $security_deposit_count= $grouped[$security_deposit_value['security_deposit']];
            $count_security_deposit=['id'=>$security_deposit_value['id'],'security_deposit'=>$security_deposit_value['security_deposit'],'security_deposit_count'=>$security_deposit_count];
                array_push($security_deposit_data_fetch,$count_security_deposit);
        }

        // bathrooms
         $product_bathroom=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 

        $grouped = $product_bathroom->groupBy('bathroom')->map(function ($row) {return $row->count();});

      $bathroom_data=product::select('id','bathroom')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->whereNotNull('bathroom')->groupBy('bathroom')->havingRaw('COUNT(*) > 0')->orderBy('bathroom', 'asc')->get(); 
        $bathroom_data_fetch=[];
        foreach ($bathroom_data as $key => $bathroom_value) {
            $bathroom_count= $grouped[$bathroom_value['bathroom']];
            $count_bathroom=['id'=>$bathroom_value['id'],'bathroom'=>$bathroom_value['bathroom'],'bathroom_count'=>$bathroom_count];
                array_push($bathroom_data_fetch,$count_bathroom);
        }
        // bedroom 
         $product_bedroom=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 

        $grouped = $product_bedroom->groupBy('bedroom')->map(function ($row) {return $row->count();});

      $bedroom_data=product::select('id','bedroom')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->whereNotNull('bedroom')->groupBy('bedroom')->havingRaw('COUNT(*) > 0')->orderBy('bedroom', 'asc')->get(); 
        $bedroom_data_fetch=[];
        foreach ($bedroom_data as $key => $bedroom_value) {
            $bedroom_count= $grouped[$bedroom_value['bedroom']];
            $count_bedroom=['id'=>$bathroom_value['id'],'bedroom'=>$bedroom_value['bedroom'],'bedroom_count'=>$bathroom_count];
                array_push($bedroom_data_fetch,$count_bedroom);
        }

        // build year
         $product_buildyear=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 

        $grouped = $product_buildyear->groupBy('buildyear')->map(function ($row) {return $row->count();});

      $buildyear_data=product::select('id','buildyear')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->whereNotNull('buildyear')->groupBy('buildyear')->havingRaw('COUNT(*) > 0')->orderBy('buildyear', 'asc')->get(); 
        $buildyear_data_fetch=[];
        foreach ($buildyear_data as $key => $buildyear_value) {
            $buildyear_value_count= $grouped[$buildyear_value['buildyear']];
            $count_buildyear=['id'=>$buildyear_value['id'],'buildyear'=>$buildyear_value['buildyear'],'buildyear_count'=>$buildyear_value_count];
                array_push($buildyear_data_fetch,$count_buildyear);
        }
        // area_unit
        $product_area_unit=product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'asc')->get(); 

        $grouped = $product_area_unit->groupBy('area_unit')->map(function ($row) {return $row->count();});

      $area_unit_data=product::select('id','area_unit')->with('Property_area_unit')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->whereNotNull('area_unit')->groupBy('area_unit')->havingRaw('COUNT(*) > 0')->orderBy('area_unit', 'asc')->get(); 
        $area_unit_data_fetch=[];
        foreach ($area_unit_data as $key => $area_unit_value) {
            $area_unit_value_count= $grouped[$area_unit_value['area_unit']];
            $count_area_unit=['id'=>$area_unit_value['id'],'area_unit'=>$area_unit_value,'area_unit_count'=>$area_unit_value_count];
                array_push($area_unit_data_fetch,$count_area_unit);
        }
        return response()->json([
            'data'=>$category_data,
            'flat_type'=> $flat_type_data_fetch,
            'security_deposit'=> $security_deposit_data_fetch,
            'bathroom'=> $bathroom_data_fetch,
            'bedroom'=>$bedroom_data_fetch,
            'buildyear'=>$buildyear_data_fetch,
            'area_unit'=>$area_unit_data_fetch
        ], 200);
    }

    public function index_featured()
    {
        $data = product::with('UserDetail','product_img','Property_Type','pro_flat_Type','product_sub_locality','product_state','product_locality','Property_area_unit')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'desc')->take(9)->get();
        return response()->json([
            'data' =>$data,
        ], 201);
    }
    public function index_featured_wishlist()
    {
       $user_id = Auth::user()->id;
        $product = product::with('UserDetail','Single_wishlist','product_img','product_comparision','Property_Type','product_state','product_locality','Property_area_unit','pro_flat_Type','product_sub_locality',)->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'desc')->take(9)->get();
            return response()->json([
            'data' =>$product,
          ], 201);
    }

    public function product_list_featured()
    {
        $data = product::with('UserDetail','product_img','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'desc')->get();
        return response()->json([
            'data' =>$data,
        ], 201);
    }

 public function product_listing_wishlist()
    {
        $user_id = Auth::user()->id;
        $product = product::with('UserDetail','product_img','product_comparision','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'desc')->get();

        // return  $product;
        $Wishlist=Wishlist::where('user_id', $user_id)->orderBy('id', 'asc')->get();
        $productcount = count($product);
        $wishlistcount = count($Wishlist);

       $productArray = json_decode(json_encode($product), true);
       $WishlistArray = json_decode(json_encode($Wishlist), true);

        // return  $productArray;
       
       // wishlist check with product id nd wishlist id
       for ($i=0; $i < $productcount; $i++) {    
            for ($j=0; $j < $wishlistcount; $j++) { 
                if($productArray[$i]['id']==$WishlistArray[$j]['product_id']){
                    $addWishlist="true";
                    array_push($productArray[$i],$addWishlist);
                }
            }
        }
        if($productArray){
            return response()->json([
            'data' =>$productArray,
          ], 201);
        }else{
            return response()->json([
            'data' =>$product,
          ], 201);
        }
    }
    public function search_pro_type(Request $request)
    {
        // return $request->input('id');
        $product = product::with('UserDetail','Property_Type','product_img')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes', 'type'=> $request->id])->get();
        return response()->json([
            'data' =>$product,
          ], 201);
        
    }
    
    public function search_pro_type_login(Request $request)
    {
      try{
          $product = product::with('UserDetail','Property_Type','product_img','Property_Type','product_comparision')->where(['delete_flag'=> '0','draft'=> '0','type'=> $request->id,'order_status'=> '0', 'enabled' => 'yes'])->get();
          return response()->json([
              'data' =>$product,
            ], 201);
        }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
        
    }
     public function property_rent_slip(Request $request) {
       try{
            $productID = $request->property_id;
          $data= product::with('property_invoice','maintenance_condition','product_payment_details')->where(['id'=>$productID,'user_id'=> Auth::user()->id])->first();
           return response()->json([
               'data' =>$data,
             ], 200);
       }catch(\Exception $e) {
           return $this->getExceptionResponse($e);
       }  
   } 
   public function crm_property_rent_slip(Request $request) {
     $request->validate([
            'property_id' => 'required'
        ]);
       try{
        $token  = $request->header('authorization');
           $object = new Authicationcheck();
           if($object->authication_check($token) == true){
              $productID = $request->property_id;
            $data= product::with('property_invoice','maintenance_condition','product_payment_details')->where(['id'=>$productID])->first();
            if($data){
               $fetch_data= crm_rentslip::make($data); 
               return response()->json([
                'data' =>$fetch_data,
                'status'=>200
            ], 200);
            }else{
                    return response()->json([
                         'message' =>'FAIL',
                         'description' => 'Property Id is Invalid !!!...',
                         'status'=>200
                     ], 200);}


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
   
   public function admin_property_rent_slip(Request $request) {
       try{
            $productID = $request->property_id;
          $data= product::with('property_invoice','maintenance_condition','product_payment_details')->where(['id'=>$productID])->first();
           return response()->json([
               'data' =>$data,
             ], 200);
       }catch(\Exception $e) {
           return $this->getExceptionResponse($e);
       }  
   } 
    public function User_propertysearchlist(Request $request)
    {
      
         if($request->product_id){
              $request->validate([
                         'product_id' => 'required|min:9'
                ]);        
           }
         
      try{
        $current_date= Carbon::now()->format('Y-m-d H:i:s');
        $product = product::with('product_img_listing','listing_wishlist','listing_pro_comp','Property_Type','pro_user_details','pro_flat_Type','Property_area_unit','product_state','product_locality','product_sub_locality')
        ->select('products.id as product_id','products.build_name','products.area','products.flat_type','products.available_for','products.furnishing_status','products.security_deposit','products.user_id','products.rent_availability','products.sale_availability','products.state_id','products.sub_locality_id','products.locality_id','products.sale_availability','products.type','products.expected_pricing','products.expected_rent','products.bedroom','products.area_unit','products.bathroom','invoices.plan_type','invoices.plan_name','invoices.invoice_no','invoices.payment_status','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw('order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
            ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
            ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')
            ->where(['rent_availability'=>'1','delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes','invoices.plan_type'=>'Let Out'])
            ->where([['invoices.payment_status','!=','CANCEL'],['invoices.payment_status','!=','RETURN'],['invoices.payment_status','!=','Payment Returned']])
           ->search($request)
           ->orderBy('plans_day_left','asc')
            ->paginate(8);
            if(count($product)<1){
                $product = product::with('product_img_listing','listing_wishlist','listing_pro_comp','Property_Type','pro_user_details','pro_flat_Type','Property_area_unit','product_state','product_locality','product_sub_locality')
                ->select('products.id as product_id','products.build_name','products.area','products.flat_type','products.available_for','products.furnishing_status','products.security_deposit','products.user_id','products.rent_availability','products.sale_availability','products.state_id','products.sub_locality_id','products.locality_id','products.sale_availability','products.type','products.expected_pricing','products.expected_rent','products.bedroom','products.area_unit','products.bathroom','invoices.plan_type','invoices.plan_name','invoices.invoice_no','invoices.payment_status','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw('order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
                    ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
                    ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')
                    ->where(['rent_availability'=>'1','delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes','invoices.plan_type'=>'Let Out'])
                    ->where([['invoices.payment_status','!=','CANCEL'],['invoices.payment_status','!=','RETURN'],['invoices.payment_status','!=','Payment Returned']])
                   ->orderBy('plans_day_left','asc')
                    ->paginate(8);
                    return response()->json([
                      'data'=> $product,
                      'status'=>200
                    ], 201);
            }else{
                return response()->json([
                  'data'=> $product,
                  'status'=>200
                ], 201);
            }
        }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        }      
    }
    public function propertysearch_list(Request $request)
    {
      
      try{
        $current_date= Carbon::now()->format('Y-m-d H:i:s');
        $product = product::with('product_img_listing','Property_Type','pro_flat_Type','pro_user_details','Property_area_unit','product_state','product_locality','product_sub_locality')
        ->select('products.id as product_id','products.area','products.flat_type','products.available_for','products.furnishing_status','products.build_name','products.security_deposit','products.user_id','products.order_status','products.rent_availability','products.sale_availability','products.state_id','products.sub_locality_id','products.locality_id','products.sale_availability','products.type','products.expected_pricing','products.expected_rent','products.bedroom','products.area_unit','products.bathroom','invoices.invoice_no','invoices.payment_status','invoices.plan_type','invoices.plan_name','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw(' order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
            ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
            ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')
            ->where(['rent_availability'=>'1','delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes','invoices.plan_type'=>'Let Out'])
            ->where([['invoices.payment_status','!=','CANCEL'],['invoices.payment_status','!=','RETURN']])
           ->search($request)
           ->orderBy('plans_day_left','asc')
            ->paginate(8);
            
            if(count($product)<1){
                $product = product::with('product_img_listing','Property_Type','pro_flat_Type','pro_user_details','Property_area_unit','product_state','product_locality','product_sub_locality')
                    ->select('products.id as product_id','products.area','products.flat_type','products.available_for','products.furnishing_status','products.build_name','products.security_deposit','products.user_id','products.order_status','products.rent_availability','products.sale_availability','products.state_id','products.sub_locality_id','products.locality_id','products.sale_availability','products.type','products.expected_pricing','products.expected_rent','products.bedroom','products.area_unit','products.bathroom','invoices.invoice_no','invoices.payment_status','invoices.plan_type','invoices.plan_name','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw(' order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
                        ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
                        ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')
                        ->where(['rent_availability'=>'1','delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes','invoices.plan_type'=>'Let Out'])
                        ->where([['invoices.payment_status','!=','CANCEL'],['invoices.payment_status','!=','RETURN']])
                    ->orderBy('plans_day_left','asc')
                        ->paginate(8);
                    return response()->json([
                      'data'=> $product,
                      'status'=>200
                    ], 201);
            }else{
                return response()->json([
                  'data'=> $product,
                  'status'=>200
                ], 201);
            }
        }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
        
    }
    public function feature_property()
    {
        $product = product::with('UserDetail','product_img','Property_area_unit')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->where('view_counter', '>=',1)->orderBy('view_counter', 'desc')->take(4)->get();

        return response()->json([
            'data' =>$product,
          ]);
        
    }
    public function Recently_view()
    {
        $product = product::with('UserDetail','Property_Type','Property_area_unit')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->where('view_counter', '>=',1)->orderBy('view_counter', 'desc')->take(4)->get();

        return response()->json([
            'data' =>$product,
          ], 201);
        
    }

      public function search_prod_by_city(Request $request){
        try{
             $locality_id = $request->locality_id;
            $productSimilar=product::with('UserDetail','Property_area_unit','Property_Type','product_img','product_state','product_locality','product_sub_locality','pro_flat_Type')->where(['locality_id'=> $locality_id,'delete_flag'=>'0','draft'=>'0','order_status'=> '0', 'enabled' => 'yes'])->orderBy('id', 'desc')->take(4)->get();
                return response()-> json([
                    'data' => $productSimilar,
                ]);
          }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
      }
     
     public function loginSimilarproperty(Request $request)
     {
        try{
            $current_date= Carbon::now()->format('Y-m-d H:i:s');
    
             $locality_id = $request->locality_id;  
              $productArray = product::with('UserDetail','Property_area_unit','product_img','product_comparision','Property_Type','product_state','product_locality','Single_wishlist','Property_area_unit','product_sub_locality','pro_flat_Type')
             ->select('products.*','invoices.id as invoice_id','invoices.plan_type','invoices.plan_name','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw(' order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
             ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
             ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')->where(['locality_id'=> $locality_id,'delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])
              ->orderBy('products.id', 'desc')->take(4)->get();
              return response()->json([
              'data' =>$productArray,
            ], 201);
         }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        }     

    }

     public function property_notes_update(Request $request){ 
      $request->validate([
                'property_id' => 'required',
                'property_notes' => 'required',
            ]);
      try{
          $user_id = Auth::user()->id;
        product::where('id', $request->property_id)->update(['property_notes' =>  $request->property_notes,'notes_updateby' =>Auth::user()->id]);
        return response()-> json([
                    'data' => 'Notes Updated',
                    'status'=> 200
                ]);
      }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
     }

     public function product_login_see(Request $request){
        try{
            $request->validate([
                'id' => 'required',
            ]);
            $prod_id = $request->id;
            $user_id = Auth::user()->id;

            $current_date= Carbon::now()->format('Y-m-d H:i:s');

            $product = product::with('amenities','product_payment_details','Property_Type','product_img','product_comparision','Single_wishlist','UserDetail','notes_updated','product_state','product_district','product_locality','product_sub_locality','Property_area_unit','willing_rent_out','maintenance_condition','aggeement_type','ageement_duration','pro_flat_Type','rent_invoice')
             ->select('products.*','invoices.id as invoice_id','invoices.plan_type','invoices.plan_name','order_plan_features.plan_created_at','order_plan_features.client_visit_priority as priority',DB::raw(' order_plan_features.product_plans_days -DATEDIFF("'.$current_date.'",invoices.plan_apply_date)  as "plans_day_left"'))
            ->leftjoin('invoices','invoices.property_uid','=','products.product_uid')
            ->leftjoin('order_plan_features','order_plan_features.order_id','=','invoices.order_id')
            ->where(['delete_flag'=> '0','enabled' => 'yes', 'draft'=> '0','products.id'=>$prod_id])
              ->first();

            product::where('id', $prod_id)->update(['view_counter' => DB::raw('view_counter + 1')]);
                return response()-> json([
                    'data' => $product,
                ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }    

     }

     public function search_prod_by_id(Request $request){
        try{
            $request->validate([
                'id' => 'required',
            ]);
            $prod_id = $request->id;
            $product_data = product::where((['delete_flag'=> '0','enabled' => 'yes','draft'=> '0','id'=>$prod_id,'order_status'=> '0']))->with('amenities','Property_Type','product_img','UserDetail','product_state','product_locality','property_room','Property_area_unit','willing_rent_out','maintenance_condition','aggeement_type','ageement_duration','pro_flat_Type','product_sub_locality')->first();

        // increase product count 
            product::where('id', $prod_id)->update(['view_counter' => DB::raw('view_counter + 1')]);

            return response()-> json([
                'data' => $product_data,
            ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
       }    

     }


     public function Login_search_home(Request $request)
    {
        $user_id = Auth::user()->id;
        $product = product::with('UserDetail','product_img','product_comparision','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->search($request)->orderBy('id', 'desc')->get();
        $Wishlist=Wishlist::where('user_id', $user_id)->orderBy('id', 'asc')->get();
        $productcount = count($product);
        $wishlistcount = count($Wishlist);

       $productArray = json_decode(json_encode($product), true);
       $WishlistArray = json_decode(json_encode($Wishlist), true);
       
       // wishlist check with product id nd wishlist id
       for ($i=0; $i < $productcount; $i++) {    
            for ($j=0; $j < $wishlistcount; $j++) { 
                if($productArray[$i]['id']==$WishlistArray[$j]['product_id']){
                    $addWishlist="true";
                    array_push($productArray[$i],$addWishlist);
                }
            }
        }
        if($productArray){
            return response()->json([
            'data' =>$productArray,
          ], 201);
        }else{
            return response()->json([
            'data' =>$product,
          ], 201);
        }
    }

     public function search_func(Request $request){
        $product = product::with('UserDetail','product_img','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes'])->search($request)->get();
        return response()->json([
            'data' =>$product,
          ], 201);
     }
    public function city_search_func(Request $request){
        $request->validate([
            'city' => 'required'
        ]);
        $data = product::Where(['city' =>  $request->city,'delete_flag' => 0,'draft'=> '0','order_status'=> '0'])->with('UserDetail','product_img','Property_Type')->get();

        return response()-> json([
            'data' => $data,
        ]);
     }
    public function city_search_login_uesr(Request $request){
        $request->validate([
            'city' => 'required'
        ]);
        $user_id = Auth::user()->id;
        $product = product::Where(['city' =>  $request->city,'delete_flag' => '0','draft'=> '0','order_status'=> '0'])->with('UserDetail','product_img','product_comparision','Property_Type')->get();

        $Wishlist=Wishlist::where('user_id', $user_id)->orderBy('id', 'asc')->get();
        $productcount = count($product);
        $wishlistcount = count($Wishlist);

       $productArray = json_decode(json_encode($product), true);
       $WishlistArray = json_decode(json_encode($Wishlist), true);
        // dd($productArray);
       
       // wishlist check with product id nd wishlist id
       for ($i=0; $i < $productcount; $i++) {    
            for ($j=0; $j < $wishlistcount; $j++) { 
                if($productArray[$i]['id']==$WishlistArray[$j]['product_id']){
                    $addWishlist="true";
                    array_push($productArray[$i],$addWishlist);
                }
            }
        }
        if($productArray){
            return response()->json([
            'data' =>$productArray,
          ], 201);
        }else{
            return response()->json([
            'data' =>$product,
          ], 201);

        }

        // return response()-> json([
        //     'data' => $data,
        // ]);
     }

    public function product_index(){

        $mer=[];
        $max_id = DB::table('products')->where('id', DB::raw("(select max(`id`) from products)"))->value("id");
        for ($id_var = 0; $id_var<=$max_id; $id_var++){
        for ($variable = $id_var; $variable == $id_var; $variable++)
            {
                $product_id_func = product::where('id','=', $variable)->get()->toArray();
                $userid = DB::table('products')->select('user_id')->where("id", $variable)->value("value");
                $tableq = DB::table('users')->select('name','email','profile_pic')->where('id', $userid)->get()->toArray();
                $merged1 = array_merge($product_id_func, $tableq);
            }
        $mer = array_merge($mer, $merged1);
        }
        return response()-> json([
            'data' => $mer,
        ]);

    }
    

    public function first(Request $request){
     
      $data1=$request->form_step1;
      $data2=$request->form_step2;
      $data3=$request->form_step3;
      $data4=$request->form_step4;

      if($data1['draft_form_id']>0){
        $product = product::where('id', $data1['draft_form_id'])->with('amenities')->first();
        $data = product::find($data1['draft_form_id']);

        $usertype = Auth::user()->usertype;
            
        $product_id=$data1['draft_form_id'];
       $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$data4['video_link']);
         $addtional_room=implode(',',$request->rooms);
          $product_uid= rand (1000,9999).time();
        // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);

       // product images functionalty
        if($db_img_length<5){
            $product_image= $request->input('images');
            $Product_img_length=count($product_image);   
            if($Product_img_length>0){
                foreach ($product_image as $value) {
                    
                    $base64_image = $value; // your base64 encoded
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);
                    $imageName = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
                    Storage::disk('public')->put($imageName, base64_decode($file_data));
                        $Product_images_data = [
                            'user_id' => $user_id,
                            'product_id' => $product_id,
                            'image' =>$imageName 
                        ];
                    Product_img::create($Product_images_data);
                }
                
            }
        }

        // $data->product_uid= $product_uid;
        // $data->user_id= $user_id;
        $data->build_name = $data1['property_name'];
        $data->type = $data1['property_type'];
        $data->bedroom = $data1['bedrooms'];
        $data->bathroom = $data1['bathrooms'];
        $data->balconies =  $data1['balconies'];
        $data->area = $data1['property_area'];
        $data->area_unit =$data1['area_unit'];
        $data->property_detail = $data1['property_desc'];

        // step 2
        $data->address = $data2['address'];
        $data->city = $data2['city'];
        // $data->locality =$data2['locality'];
        $data->map_latitude = $data2['map_latitude'];
        $data->map_longitude = $data2['map_longitude'];

        // step 3
        $data->additional_rooms=$addtional_room;
        $data->additional_rooms_status=$data3['additional_rooms'];
        $data->availability_condition = $data3['availability_condition'];
        $data->rera_registration_status = $data3['rera_registration_status'];
        $data->facing_towards = $data3['facing_towards'];
        $data->furnishing_status = $data3['furnishings'];
        $data->additional_parking_status = $data3['reserved_parking'];
        $data->parking_covered_count = $data3['parking_covered_count'];
        $data->parking_open_count = $data3['parking_open_count'];
        $data->total_floors = $data3['total_floors'];
        $data->property_on_floor = $data3['property_floor'];
        $data->buildyear = $data3['year_built'];
        $data->possession_by = $data3['possession_by'];

        // step 4
        $data->inc_electricity_and_water_bill = $data4['electricity_water'];
        $data->expected_pricing = $data4['expected_pricing'];
        $data->sale_availability =1;
        $data->maintenance_charge_status = $data4['maintenance_charge_status'];
        $data->maintenance_charge = $data4['maintenance_charge'];
        $data->maintenance_charge_condition =$data4['maintenance_charge_condition'];
        $data->price_negotiable =$data4['price_negotiable'];
        $data->negotiable_status=$data4['price_negotiable_status'];
        $data->ownership=$data4['ownership'];
        $data->tax_govt_charge = $data4['tax_govt_charge'];
        $data->draft=$data4['draft_form_id'];
        $data->video_link = $video_link;
        $data->enabled = 'yes';
        $data->save();
        $product_id=$data1['draft_form_id'];
       $user_id = Auth::user()->id;
       // check amenties 
       $amenities_check=$request->amenties;
       $length=count($amenities_check);
       if($length>0){
            foreach ($amenities_check as $Check_amenities) {
                $ProductAmenties = [
                    'amenties' =>$Check_amenities,
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ];
                
                $ProductAmenties_Count = ProductAmenties::where('user_id',$user_id)->where('product_id',$product_id)->where('amenties',$ProductAmenties['amenties'])->get();
                $count = count($ProductAmenties_Count);
                
                if($count==0){
                ProductAmenties::create($ProductAmenties);
                }
            }
        }
        return response() -> json([
                'message' => 'Successfully Updated',
                'last_id' => $data1['draft_form_id'],
        ]);
      }else{
        $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$data4['video_link']);

         $addtional_room=implode(',',$request->rooms);
           
         $product_uid= rand (1000,9999).time();

            $product_data = new Product([
            'user_id' => $user_id ,
            'product_uid' => $product_uid,
            'build_name' =>$data1['property_name'],
            'type' =>$data1['property_type'],
            'bedroom' => $data1['bedrooms'],
            'bathroom' => $data1['bathrooms'],
            'balconies' => $data1['balconies'],
            'area' => $data1['property_area'],
            'area_unit' => $data1['area_unit'],
            'property_detail' =>$data1['property_desc'],

            // step 2
            'address' => $data2['address'],
            // 'locality' =>  $data2['locality'],
            'map_latitude' => $data2['map_latitude'],
            'map_longitude' => $data2['map_longitude'],

            // step 3
            'additional_rooms_status' => $data3['additional_rooms'],
            'additional_rooms' => $addtional_room,
            'availability_condition' => $data3['availability_condition'],
            'rera_registration_status' =>$data3['rera_registration_status'],
            'facing_towards'=>$data3['facing_towards'],
            'furnishing_status'=>$data3['furnishings'],
            'additional_parking_status' =>$data3['reserved_parking'],
            'parking_covered_count' => $data3['parking_covered_count'],
            'parking_open_count' =>$data3['parking_open_count'],
            'property_on_floor' =>$data3['property_floor'],
            'total_floors' =>$data3['total_floors'],
            'buildyear' =>$data3['year_built'],
            'possession_by' =>$data3['possession_by'],

            // step 4
            'inc_electricity_and_water_bill' => $data4['electricity_water'],
            'expected_pricing' =>$data4['expected_pricing'],
            'sale_availability' =>1,
            'maintenance_charge_status' =>$data4['maintenance_charge_status'],
            'maintenance_charge' =>$data4['maintenance_charge'],
            'maintenance_charge_condition' =>$data4['maintenance_charge_condition'],
            'price_negotiable' =>$data4['price_negotiable'],
            'negotiable_status' =>$data4['price_negotiable_status'],
            'ownership' =>$data4['ownership'],
            'tax_govt_charge' =>$data4['tax_govt_charge'],
            'video_link'=>$video_link,
            'draft' =>$data4['draft_form_id'],
            'enabled' => 'yes',
            // 'possession_by' => $request->possession_by ,
            // 'brokerage_charges' => $request->brokerage_charges ,
            ]);

            $user_type = Auth::user()->usertype;

            if ($user_type == 1)
                return response()->json([
                    'message' => 'Unauthorised User',
                ], 201);

            $product_data->save();
            $lastid=$product_data->id;
            eventtracker::create(['symbol_code' => '8', 'event' => Auth::user()->name.' created a new property listing for rent.']);

       
         $product_id=$product_data->id;
         // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);
        // product images functionalty
        if($db_img_length<5){
           $product_image= $request->input('images');
           $Product_img_length=count($product_image);   
            if($Product_img_length>0){
                foreach ($product_image as $value) {   
                    $base64_image = $value; // your base64 encoded
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);
                    $imageName = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
                    Storage::disk('public')->put($imageName, base64_decode($file_data));
                        $Product_images_data = [
                            'user_id' => $user_id,
                            'product_id' => $product_id,
                            'image' =>$imageName 
                        ];
                    Product_img::create($Product_images_data);
                }
            }
        }

           $amenities=$request->amenties;
           $length=count($amenities);
            foreach ($amenities as $amenties_value) {   
             $ProductAmenties = [
                    'amenties' =>$amenties_value,
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ];
                ProductAmenties::create($ProductAmenties);

            }
            return response()->json([
                'message' => 'Successfully created',
                'last_id' => $lastid,
            ], 201);
      }

    }

    public function insert_product_rent(Request $request)
    {
      $data1=$request->form_step1;
      $data2=$request->form_step2;
      $data3=$request->form_step3;
      $data4=$request->form_step4;
      // return $data3['additional_rooms'];

      if($data1['draft_form_id']>0){
        $product = product::where('id', $data1['draft_form_id'])->with('amenities')->first();
        $data = product::find($data1['draft_form_id']);

        $usertype = Auth::user()->usertype;
            
        $product_id=$data1['draft_form_id'];
       $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$data4['video_link']);
    
          $product_uid= rand (1000,9999).time();
        // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);

       // product images functionalty
        if($db_img_length<10){
            $product_image= $request->input('images');
            $Product_img_length=count($product_image);   
            if($Product_img_length>0){
                foreach ($product_image as $value) {
                    
                    $base64_image = $value; // your base64 encoded
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);
                    $imageName = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
                    Storage::disk('public')->put($imageName, base64_decode($file_data));
                        $Product_images_data = [
                            'user_id' => $user_id,
                            'product_id' => $product_id,
                            'image' =>$imageName 
                        ];
                    Product_img::create($Product_images_data);
                }
                
            }
        }

        // $data->product_uid= $product_uid;
        // $data->user_id= $user_id;
        $data->build_name = $data1['property_name'];
        $data->type = $data1['property_type'];
        $data->bedroom = $data1['bedrooms'];
        $data->bathroom = $data1['bathrooms'];
        $data->balconies =  $data1['balconies'];
        $data->area = $data1['property_area'];
        $data->area_unit =$data1['area_unit'];
        $data->flat_type =$data1['flat_type'];
        $data->property_detail = $data1['property_desc'];
         $data->property_notes = $data1['property_notes'];
        $data->notes_updateby=$user_id;

        // step 2
        $data->address = $data2['address'];
        $data->address_details = $data2['address_details'];
        $data->state_id = $data2['city'];
        $data->district_id = $data2['district_id'];
        $data->locality_id =$data2['locality'];
        $data->sub_locality_id =$data2['sub_locality'];
        $data->map_latitude = $data2['map_latitude'];
        $data->map_longitude = $data2['map_longitude'];

        // step 3
        // $data->additional_rooms=$addtional_room;
        $data->additional_rooms_status=$data3['additional_rooms'];
           // return $request->rooms;
          if($data3['additional_rooms']== 1 ){
                        // check amenties
                $addtional_rooms=$request->rooms;
                $length=count($addtional_rooms);
                 $room_delete= property_room_pivot::where('product_id',$product_id)->delete();
                if($length>0){
                    foreach ($addtional_rooms as $rooms) {
                        $room_data = [
                            'room_id' =>$rooms,
                            'product_id' => $product_id
                        ];
                        property_room_pivot::create($room_data);
                    }
                }
            }
        $data->agreement_type=$data3['agreement_type'];
        $data->duration_of_rent_aggreement=$data3['agreement_duration'];
        $data->available_for = $data3['available_date'];
        $data->facing_towards = $data3['facing_towards'];
        $data->furnishing_status = $data3['furnishings'];
        $data->month_of_notice = $data3['notice_month'];
        $data->additional_parking_status = $data3['reserved_parking'];
        $data->parking_covered_count = $data3['parking_covered_count'];
        $data->parking_open_count = $data3['parking_open_count'];
        $data->total_floors = $data3['total_floors'];
        $data->property_on_floor = $data3['property_floor'];
        $data->willing_to_rent_out_to = $data3['willing_to_rent'];
        $data->buildyear = $data3['year_built'];

        // step 4
        $data->inc_electricity_and_water_bill = $data4['electricity_water'];
        $data->expected_rent = $data4['expected_rent'];
        $data->rent_availability =1;
        $data->maintenance_charge_status = $data4['maintenance_charge_status'];
        $data->maintenance_charge = $data4['maintenance_charge'];
        $data->maintenance_charge_condition =$data4['maintenance_charge_condition'];
        $data->price_negotiable =$data4['price_negotiable'];
        $data->negotiable_status=$data4['price_negotiable_status'];
        $data->security_deposit=$data4['security_deposit'];
        $data->draft=$data4['draft_form_id'];
        $data->rent_cond =1;
        $data->video_link = $video_link;
        // return $data;
        $data->save();
        $product_id=$data1['draft_form_id'];
       $user_id = Auth::user()->id;
       // check amenties 
       $amenities_check=$request->amenties;
       $length=count($amenities_check);
       if($length>0){
            foreach ($amenities_check as $Check_amenities) {
                $ProductAmenties = [
                    'amenties' =>$Check_amenities,
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ];
                
                $ProductAmenties_Count = ProductAmenties::where('user_id',$user_id)->where('product_id',$product_id)->where('amenties',$ProductAmenties['amenties'])->get();
                $count = count($ProductAmenties_Count);
                
                if($count==0){
                ProductAmenties::create($ProductAmenties);
                }
            }
        }
        return response() -> json([
                'message' => 'Successfully Updated',
                'last_id' => $data1['draft_form_id'],
        ]);
      }else{
        $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$data4['video_link']);

           
         $product_uid= rand (1000,9999).time();

            $product_data = [
            'user_id' => $user_id,
            'product_uid' => $product_uid,
            'build_name' =>$data1['property_name'],
            'type' =>$data1['property_type'],
            'bedroom' => $data1['bedrooms'],
            'bathroom' => $data1['bathrooms'],
            'balconies' => $data1['balconies'],
            'area' => $data1['property_area'],
            'area_unit' => $data1['area_unit'],
            'flat_type' =>$data1['flat_type'],
            'property_detail' =>$data1['property_desc'],
            'property_notes' => $data1['property_notes'],
            'notes_updateby'=>$user_id,

            // step 2
            'address_details' =>  $data2['address_details'],
            'address' => $data2['address'],
             'state_id' => $data2['city'],
            'district_id' =>$data2['district_id'],
            'locality_id' =>  $data2['locality'],
            'sub_locality_id' => $data2['sub_locality'],
            'map_latitude' => $data2['map_latitude'],
            'map_longitude' => $data2['map_longitude'],

            // step 3
            'additional_rooms_status' => $data3['additional_rooms'],
            // 'additional_rooms' => $addtional_room,
            'agreement_type' =>$data3['agreement_type'],
            'duration_of_rent_aggreement' =>$data3['agreement_duration'] ,
            'available_for' =>$data3['available_date'],
            'facing_towards'=>$data3['facing_towards'],
            'furnishing_status'=>$data3['furnishings'],
            'month_of_notice'=>$data3['notice_month'],
            'additional_parking_status' =>$data3['reserved_parking'],
            'parking_covered_count' => $data3['parking_covered_count'],
            'parking_open_count' =>$data3['parking_open_count'],
            'property_on_floor' =>$data3['property_floor'],
            'total_floors' =>$data3['total_floors'],
            'willing_to_rent_out_to' =>$data3['willing_to_rent'],
            'buildyear' =>$data3['year_built'],

            // step 4
            'inc_electricity_and_water_bill' => $data4['electricity_water'],
            'expected_rent' =>$data4['expected_rent'],
            'rent_availability' =>1,
            'maintenance_charge_status' =>$data4['maintenance_charge_status'],
            'maintenance_charge' =>$data4['maintenance_charge'],
            'maintenance_charge_condition' =>$data4['maintenance_charge_condition'],
            'price_negotiable' =>$data4['price_negotiable'],
            'negotiable_status' =>$data4['price_negotiable_status'],
            'security_deposit' =>$data4['security_deposit'],
            // 'tax_govt_charge' =>$data4['tax_govt_charge'],
            'rent_cond' =>1,
            'video_link'=>$video_link,
            'draft' =>$data4['draft_form_id'],
            // 'possession_by' => $request->possession_by ,
            // 'brokerage_charges' => $request->brokerage_charges ,
            ];

            $user_type = Auth::user()->usertype;

            if ($user_type == 1)
                return response()->json([
                    'message' => 'Unauthorised User',
                ], 201);
                // return $product_data;
           $product_db_result=product::create($product_data);
            $lastid=$product_db_result->id;
            eventtracker::create(['symbol_code' => '8', 'event' => Auth::user()->name.' created a new property listing for rent.']);

       
         $product_id=$lastid;
          if($data3['additional_rooms']== 1 ){
                        // check amenties
              $addtional_rooms=$request->rooms;
              $length=count($addtional_rooms);
              if($length>0){
                $room_delete= property_room_pivot::where('product_id',$product_id)->delete();
                  foreach ($addtional_rooms as $rooms) {
                      $room_data = [
                          'room_id' =>$rooms,
                          'product_id' => $product_id
                      ];
                      property_room_pivot::create($room_data);
                  }
              }
            }
         // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);
        // product images functionalty
        if($db_img_length<5){
           $product_image= $request->input('images');
           $Product_img_length=count($product_image);   
            if($Product_img_length>0){
                foreach ($product_image as $value) {   
                    $base64_image = $value; // your base64 encoded
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);
                    $imageName = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
                    Storage::disk('public')->put($imageName, base64_decode($file_data));
                        $Product_images_data = [
                            'user_id' => $user_id,
                            'product_id' => $product_id,
                            'image' =>$imageName 
                        ];
                    Product_img::create($Product_images_data);
                }
            }
        }

           $amenities=$request->amenties;
           $length=count($amenities);
            foreach ($amenities as $amenties_value) {   
             $ProductAmenties = [
                    'amenties' =>$amenties_value,
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ];
                ProductAmenties::create($ProductAmenties);

            }
            return response()->json([
                'message' => 'Successfully created',
                'last_id' => $lastid,
            ], 201);
      }
       
    }

    public function delete_product (Request $request){
        $request->validate([
            'product_id' => 'required',
        ]);
        $product_userid = product::where('id', $request->product_id)->value('user_id');
        $user_id = Auth::user()->id;

        if ($user_id != $product_userid)
            return response()->json([
                'message' => 'Unauthorised User',
            ], 401);

        product::where('id', $request->product_id)->update(['delete_flag' => '1' ]);

        // propduct count inactive
        UserProductCount::where('product_id', $request->product_id)->update(['status' => '0']);

        // wishlist inactive
        Wishlist::where('product_id', $request->product_id)->update(['status' => '0']);

        // property comaprision
        Product_Comparision::where('product_id', $request->product_id)->update(['status' => '0']);

        return response()->json([
            'message' => 'Successfully deleted Product',
        ], 201);

    }

    public function agent_properties()
    {
        try{

            $user_id = Auth::user()->id;

            $data = product::with('product_img')->where('user_id', $user_id)->where(['delete_flag'=> '0','draft'=> '0'])->orderBy('id', 'desc')->paginate(5);
            //$tableq = DB::table('users')->select('id','name','email','profile_pic')->get();
            return response()->json([
                //'users'=> $tableq,
                'data' =>$data,
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }   

    }
    public function Draft_properties()
    {
        try{
            $user_id = Auth::user()->id;
            $data = product::with('product_img')->where(['delete_flag'=> '0','draft'=> '1','order_status'=> '0','user_id'=>  $user_id])->orderBy('id', 'desc')->paginate(5);
            return response()->json([
                'data' =>$data,
            ], 200);

        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 

    }

    public function dashboard_indexer(){

        $user_id = Auth::user()->id;
        $views = product::select('view_counter')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0','user_id'=>  $user_id])->get()->sum('view_counter');

        $property_count = product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0','user_id'=>  $user_id])->get()->count();

       $wishlist_data= Wishlist::where(['status'=> '1','user_id' =>$user_id])->get()->count();


        return response()->json([
            'view_count' => $views,
            'property_count' => $property_count,
            'wishlist_count'  =>$wishlist_data,
        ], 200);
    }
    public function update_Sales_product(Request $request){
      $data1=$request->form_step1;
      $data2=$request->form_step2;
      $data3=$request->form_step3;
      $data4=$request->form_step4;
        $request -> validate([
            'id' => 'required'
        ]);
        $product = product::where('id', $request->id)->with('amenities')->first();

        $data = product::find($request->id);
        $usertype = Auth::user()->usertype;
            
        $product_id=$request->id;
       $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$data4['video_link']);
       
         $addtional_room=implode(',',$request->rooms);
         // return $additional_rooms;
        // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id', $product_id)->get();
        $db_img_length=count($DB_img);

       // product images functionalty
        if($db_img_length<5){
            $product_image= $request->input('images');
            $Product_img_length=count($product_image);   
            if($Product_img_length>0){
                foreach ($product_image as $value) {
                    
                    $base64_image = $value; // your base64 encoded
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);
                    $imageName = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
                    Storage::disk('public')->put($imageName, base64_decode($file_data));
                        $Product_images_data = [
                            'user_id' => $user_id,
                            'product_id' => $product_id,
                            'image' =>$imageName 
                        ];
                    Product_img::create($Product_images_data);
                }
                
            }
        }

        // $data->product_uid= $product_uid;
        // $data->user_id= $user_id;
        $data->build_name = $data1['property_name'];
        $data->type = $data1['property_type'];
        $data->bedroom = $data1['bedrooms'];
        $data->bathroom = $data1['bathrooms'];
        $data->balconies =  $data1['balconies'];
        $data->area = $data1['property_area'];
        $data->area_unit =$data1['area_unit'];
        $data->property_detail = $data1['property_desc'];

        // step 2
        $data->address = $data2['address'];
        // $data->locality =$data2['locality'];
        $data->map_latitude = $data2['map_latitude'];
        $data->map_longitude = $data2['map_longitude'];

        // step 3
        $data->additional_rooms=$addtional_room;
        $data->additional_rooms_status=$data3['additional_rooms'];
        $data->availability_condition = $data3['availability_condition'];
        $data->rera_registration_status = $data3['rera_registration_status'];
        $data->facing_towards = $data3['facing_towards'];
        $data->furnishing_status = $data3['furnishings'];
        $data->additional_parking_status = $data3['reserved_parking'];
        if($data3['reserved_parking'] == 1){
            $data->parking_covered_count = $data3['parking_covered_count'];
            $data->parking_open_count = $data3['parking_open_count']; 
        }else{
            $data->parking_covered_count =null;
            $data->parking_open_count =null;
        }
        $data->total_floors = $data3['total_floors'];
        $data->property_on_floor = $data3['property_floor'];
        $data->buildyear = $data3['year_built'];
        $data->possession_by = $data3['possession_by'];

        // step 4
        $data->inc_electricity_and_water_bill = $data4['electricity_water'];
        $data->expected_pricing = $data4['expected_pricing'];
        $data->sale_availability =1;
        $data->maintenance_charge_status = $data4['maintenance_charge_status'];
        if($data4['maintenance_charge_status'] == 1){
            $data->maintenance_charge = $data4['maintenance_charge'];
            $data->maintenance_charge_condition =$data4['maintenance_charge_condition'];
        }else{
            $data->maintenance_charge_condition =null;
            $data->maintenance_charge =null;
        }
        $data->negotiable_status=$data4['price_negotiable_status'];
        if($data4['price_negotiable_status'] == 1){
        $data->price_negotiable =$data4['price_negotiable'];
        }else{
           $data->price_negotiable =null;
        }
        $data->ownership=$data4['ownership'];
        $data->tax_govt_charge = $data4['tax_govt_charge'];
        $data->draft=$data4['draft_form_id'];
        $data->video_link = $video_link;
        $data->save();
        $product_id=$request->id;
       $user_id = Auth::user()->id;

      if($data3['furnishings']== 1){
       // check amenties
       $amenities_check=$request->amenties;
       $length=count($amenities_check);
       if($length>0){
            foreach ($amenities_check as $Check_amenities) {
                $ProductAmenties = [
                    'amenties' =>$Check_amenities,
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ];
                
                $ProductAmenties_Count = ProductAmenties::where('user_id',$user_id)->where('product_id',$product_id)->where('amenties',$ProductAmenties['amenties'])->get();
                $count = count($ProductAmenties_Count);
                
                if($count==0){
                ProductAmenties::create($ProductAmenties);
                }
            }
        }

    }else{
        if($request->amenties){
           // uncheck Amenties
           $amenity_Uncheck=$request->amenties;
           $Uncheck_length=count($amenity_Uncheck);
           if($Uncheck_length>0){
                foreach ($amenity_Uncheck as $uncheck_amen) {
                    $Uncheck_Amenties = [
                        'amenties' =>$uncheck_amen,
                        'user_id' => $user_id,
                        'product_id' => $product_id
                    ];

                    $Amenties_uncheck_Count = ProductAmenties::where('user_id',$user_id)->where('product_id',$product_id)->where('amenties',$Uncheck_Amenties['amenties'])->get();
                    $count = count($Amenties_uncheck_Count);
                    
                    if($count>0){
                    ProductAmenties::where($Uncheck_Amenties)->delete();
                    }
                }
            }   
        }

    }
        return response() -> json([
            'message' => 'Successfully Updated',
            'data' => $data
        ]);
    }

    public function get_proeprty_id(Request $request){
      $request->validate([
                'product_id' => 'required|integer',
            ]);

        $product_id = $request->input('product_id');
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
               $data = product::select('id','build_name')->where(['id'=>$product_id,'delete_flag'=> '0'])->first();
              if($data){
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
    public function get_crm_property(Request $request){
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $data = product::where(['delete_flag'=> '0','enabled'=>'no','draft'=>'0'])->with('amenities','UserDetail','product_img','product_state','product_locality','property_room','Property_area_unit','willing_rent_out','maintenance_condition','aggeement_type','ageement_duration','letout_invoice')->orderBy('id', 'desc')->get();
                return response()->json([
                    'message' =>'SUCCESS',
                    'data' => $data,
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
    

     public function get_property_byid(Request $request){
       $request->validate([
                'property_id' => 'required|integer',
            ]);
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $property_id =$request->property_id;
                // return $property_id;
                $data = product::where(['delete_flag'=> '0','id'=>$request->property_id])->with('amenities','Property_Type','product_img','UserDetail','product_state','product_district','product_locality','product_sub_locality','Property_area_unit','property_room','willing_rent_out','maintenance_condition','aggeement_type','ageement_duration','letout_invoice')->get();
                 if(count($data)>0){
                  $static_data=$object->static_data();
                    return response()->json([
                         'message' =>'SUCCESS',
                         'data' => $data,
                          'static_data'=>$static_data,
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
                    'message' => 'Failure',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            }       
        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        }    

     }
    public function get_all_property_userDetails(Request $request){
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $property = product::where(['delete_flag'=> '0'])->with('amenities','Property_Type','product_img','UserDetail','product_state','product_locality','property_room','Property_area_unit','willing_rent_out','maintenance_condition','aggeement_type','ageement_duration')->orderBy('id', 'desc')->get();
                $user = user::get();
                $static_data=$object->static_data();
                return response()->json([
                    'message' =>'SUCCESS',
                    'property' => $property,
                    'user'=>$user,
                    'static_data'=>$static_data,
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
    public function crm_create_product_rent(Request $request){
        $request->validate([
            'crm_user_email' => 'required|email',
            'draft_id'=>'required|integer',
            'userId'=>'required|integer'
        ]);
       try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $data = product::find($request->id);
                    $product_uid= rand (1000,9999).time();

                        $product_data = [
                        'user_id' => $request->userId,
                        'crm_user_email'=>$request->crm_user_email,
                        'product_uid' => $product_uid,
                        'build_name' =>$request->build_name,
                        'type' =>$request->type,
                        'bedroom' => $request->bedroom,
                        'bathroom' => $request->bathroom,
                        'balconies' => $request->balconies,
                        'area' =>$request->area,
                        'area_unit' => $request->area_unit,
                        'flat_type' =>$request->flat_type,
                        'property_detail' =>$request->property_detail,
                        'property_notes' => $request->property_notes,

                        // step 2
                        'address_details' => $request->address_details,
                        'address' =>$request->address,
                        'state_id' =>$request->state_id,
                        'district_id' =>$request->district_id,
                        'locality_id' => $request->locality_id,
                        'sub_locality_id' => $request->sub_locality_id,
                        'map_latitude' => $request->map_latitude,
                        'map_longitude' => $request->map_longitude,

                        // step 3
                        'additional_rooms_status' =>(string)$request->additional_rooms_status,
                        'agreement_type' => $request->agreement_type,
                        'duration_of_rent_aggreement' => $request->duration_of_rent_aggreement,
                        'available_for' =>$request->available_for,
                        'facing_towards'=>$request->facing_towards,
                        'furnishing_status'=>(string)$request->furnishing_status,
                        'month_of_notice'=>$request->month_of_notice,
                        'additional_parking_status' =>(string)$request->additional_parking_status,
                        'parking_covered_count' =>$request->parking_covered_count,
                        'parking_open_count' =>$request->parking_open_count,
                        'property_on_floor' =>$request->property_on_floor,
                        'total_floors' =>$request->total_floors,
                        'willing_to_rent_out_to' =>$request->willing_to_rent_out_to,
                        'buildyear' =>$request->buildyear,

                        // step 4
                        'inc_electricity_and_water_bill' =>$request->inc_electricity_and_water_bill,
                        'expected_rent' =>$request->expected_rent,
                        'rent_availability' =>1,
                        'maintenance_charge_status' =>$request->maintenance_charge_status,
                        'maintenance_charge' =>$request->maintenance_charge,
                        'maintenance_charge_condition' =>$request->maintenance_charge_condition,
                        'negotiable_status' =>$request->negotiable_status,
                        'price_negotiable' =>$request->price_negotiable,
                        'security_deposit' =>$request->security_deposit,
                        'rent_cond' =>1,
                        // 'video_link'=>$video_link,
                        'draft' =>(string)$request->draft_id,
                        'property_mode'=>$request->property_mode
                        ];
                      // return  $product_data['additional_rooms_status'];
                    $product_db_result=product::create($product_data);
                   
                    $product_id=$product_db_result->id;
                    if($request->additional_rooms_status== 1 ){
                        // check amenties
                      if($request->additional != NULL){

                        $addtional_rooms=$request->additional;
                        $length=count($addtional_rooms);
                        if($length>0){
                            $room_delete= property_room_pivot::where('product_id',$product_id)->delete();
                            foreach ($addtional_rooms as $rooms) {
                                $room_data = [
                                    'room_id' =>$rooms,
                                    'product_id' => $product_id
                                ];
                                property_room_pivot::create($room_data);
                            }
                        } 
                      }
                    }
                    if($request->furnishing_status == 1 ){
                        // check amenties
                            $amenities_check=$request->amenityDetail;
                            $length=count($amenities_check);
                            if($length>0){
                                foreach ($amenities_check as $Check_amenities) {
                                    $ProductAmenties = [
                                        'amenties' =>$Check_amenities,
                                        'user_id' => $request->userId,
                                        'product_id' => $product_id
                                    ];
                                    ProductAmenties::create($ProductAmenties);
                                }
                            }
                        }
                        return response()->json([
                            'message' =>'SUCCESS',
                            'description' => 'Successfully created  Property',
                            'status'=>201
                        ], 201);
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
    public function crm_update_product_rent(Request $request){
      // return $request->input();
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $request -> validate([
                    'id' => 'required|integer'
                ]);
               $product_id=$request->id;   
               $data = product::where(['delete_flag'=> '0'])->find($product_id);
               if($data){
                $data->build_name = $request->build_name;
                $data->type = $request->type;
                $data->bedroom =$request->bedroom;
                $data->bathroom =$request->bathroom;
                $data->balconies = $request->balconies;
                $data->area =$request->area;
                $data->area_unit =$request->area_unit;
                $data->flat_type =$request->flat_type;
                $data->property_detail =$request->property_detail;
                $data->property_notes = $request->property_notes;
                // step 2
                $data->address =$request->address;
                $data->address_details = $request->address_details;
                $data->state_id =$request->state_id;
                $data->district_id = $request->district_id;
                $data->locality_id =$request->locality_id;
                $data->sub_locality_id =$request->sub_locality_id;
                $data->map_latitude = $request->map_latitude;
                $data->map_longitude = $request->map_longitude;
                // step 3                 
                $data->additional_rooms_status=$request->additional_rooms_status;
                if($request->additional_rooms_status== 1 ){
                    // check amenties
                    $addtional_rooms=$request->additional;
                    $length=count($addtional_rooms);
                    if($length>0){
                        $room_delete= property_room_pivot::where('product_id',$product_id)->delete();
                        foreach ($addtional_rooms as $rooms) {
                            $room_data = [
                                'room_id' =>$rooms,
                                'product_id' => $product_id
                            ];
                            property_room_pivot::create($room_data);
                        }
                    }
                }else{
                    $room_delete= property_room_pivot::where('product_id',$product_id)->delete();
                }

              
                $data->agreement_type=$request->agreement_type;
                $data->duration_of_rent_aggreement=$request->duration_of_rent_aggreement;
                $data->available_for = $request->available_for;
                $data->facing_towards =$request->facing_towards;
                $data->furnishing_status =$request->furnishing_status;
                $data->month_of_notice =$request->month_of_notice;
                $data->total_floors = $request->total_floors;
                $data->property_on_floor =$request->property_on_floor;
                $data->willing_to_rent_out_to =$request->willing_to_rent_out_to;
                $data->buildyear = $request->buildyear;
                $data->additional_parking_status=$request->additional_parking_status;
               if($request->additional_parking_status == 1){
                    $data->parking_covered_count=$request->parking_covered_count;
                    $data->parking_open_count=$request->parking_open_count;
                }else{  
                    $data->parking_covered_count=NULL;
                    $data->parking_open_count=NULL;
                }
             //    step 4
                $data->inc_electricity_and_water_bill =$request->inc_electricity_and_water_bill;
                $data->expected_rent = $request->expected_rent;
                $data->rent_availability =1;
                $data->maintenance_charge_status = $request->maintenance_charge_status;
                if($request->maintenance_charge_status == 1){
                    $data->maintenance_charge=$request->maintenance_charge;
                    $data->maintenance_charge_condition=$request->maintenance_charge_condition;
                }else{
                    $data->maintenance_charge=NULL;
                    $data->maintenance_charge_condition=NULL;    
                }
               $data->security_deposit=$request->security_deposit;
                $data->negotiable_status=$request->negotiable_status;
                if($request->negotiable_status==1){
                    $data->price_negotiable=$request->price_negotiable;         
                }else{
                    $data->price_negotiable=NULL;
                }
                // $data->draft=$request->draft_form_id;
                $data->rent_cond =1;
                if($request->video_link){
                    $data->video_link=str_replace("https://www.youtube.com/watch?v=","",$request->video_link);
                
                }
                $data->updated_at= Carbon::now()->format('Y-m-d H:i:s');
                
                if($data['furnishing_status']== 1 ){
                    // check amenties
                    $amenities_check=$request->amenityDetail;
                    $length=count($amenities_check);
                    if($length>0){
                        $amenity_delete= ProductAmenties::where('product_id',$product_id)->delete();
                        foreach ($amenities_check as $Check_amenities) {
                            $ProductAmenties = [
                                'amenties' =>$Check_amenities,
                                'user_id' => $request->userId,
                                'product_id' => $product_id
                            ];
                            ProductAmenties::create($ProductAmenties);
                        }
                    }
                }else{
                    // return "iqbal";
                    //  return $request->amenityDetail;
                    // if($request->amenityDetail){
                        $amenity_delete= ProductAmenties::where('product_id',$product_id)->delete();
                    // }
                }
                if($data->save()){
                 return response() -> json([
                    'message' => 'SUCCESS',
                    'description'=>'Successfully Updated',
                     'status'=> 200
                 ]);
                }else{
                 return response() -> json([
                     'message' => 'FAIL',
                     'description'=>'Somthing Error !!!...',
                     'status'=> 404,
                 ]);
                } 
               }else{
                return response() -> json([
                    'message' => 'FAIL',
                    'description'=>'This Product Deatils  Inavalid!!!..',
                    'status'=> 404,
                ]);
               }
              
            } else{                
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
     public function product_rent_update(Request $request)
    {
      $data1=$request->form_step1;
      $data2=$request->form_step2;
      $data3=$request->form_step3;
      $data4=$request->form_step4;
        $request -> validate([
            'id' => 'required'
        ]);
        $product = product::where('id', $request->id)->with('amenities')->first();

        $data = product::find($request->id);
        $usertype = Auth::user()->usertype;
            
        $product_id=$request->id;
       $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$data4['video_link']);
       
         // return $additional_rooms;
        // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id', $product_id)->get();
        $db_img_length=count($DB_img);

       // product images functionalty
        if($db_img_length<10){
            $product_image= $request->input('images');
            $Product_img_length=count($product_image);   
            if($Product_img_length>0){
                foreach ($product_image as $value) {
                    
                    $base64_image = $value; // your base64 encoded
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);
                    $imageName = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
                    Storage::disk('public')->put($imageName, base64_decode($file_data));
                        $Product_images_data = [
                            'user_id' => $user_id,
                            'product_id' => $product_id,
                            'image' =>$imageName 
                        ];
                    Product_img::create($Product_images_data);
                }
                
            }
        }

        // $data->product_uid= $product_uid;
        // $data->user_id= $user_id;
        $data->build_name = $data1['property_name'];
        $data->type = $data1['property_type'];
        $data->bedroom = $data1['bedrooms'];
        $data->bathroom = $data1['bathrooms'];
        $data->balconies =  $data1['balconies'];
        $data->area = $data1['property_area'];
        $data->area_unit =$data1['area_unit'];
        $data->flat_type =$data1['flat_type'];
        $data->property_detail = $data1['property_desc'];

         $data->property_notes = $data1['property_notes'];
        $data->notes_updateby=$user_id;

        // step 2
        $data->address = $data2['address'];
        $data->address_details = $data2['address_details'];
        $data->state_id = $data2['city'];
        $data->district_id = $data2['district_id'];
        $data->locality_id =$data2['locality'];
        $data->sub_locality_id =$data2['sub_locality'];
        $data->map_latitude = $data2['map_latitude'];
        $data->map_longitude = $data2['map_longitude'];

        // step 3
        // $data->additional_rooms=$addtional_room;
        $data->additional_rooms_status=$data3['additional_rooms'];
        if($data3['additional_rooms']== 1 ){
            // check amenties
            $addtional_rooms=$request->rooms;
            $length=count($addtional_rooms);
            $room_delete= property_room_pivot::where('product_id',$product_id)->delete();
            if($length>0){
                foreach ($addtional_rooms as $rooms) {
                    $room_data = [
                        'room_id' =>$rooms,
                        'product_id' => $product_id
                    ];
                    property_room_pivot::create($room_data);
                }
            }
        }else{
            $room_delete= property_room_pivot::where('product_id',$product_id)->delete();
        }
        $data->agreement_type=$data3['agreement_type'];
        $data->duration_of_rent_aggreement=$data3['agreement_duration'];
        // $data->availability_condition = $data3['availability_condition'];
        $data->available_for = $data3['available_date'];
        $data->facing_towards = $data3['facing_towards'];
        $data->furnishing_status = $data3['furnishings'];
        $data->month_of_notice = $data3['notice_month'];
        $data->additional_parking_status = $data3['reserved_parking'];
        if($data3['reserved_parking'] == 1){
            $data->parking_covered_count = $data3['parking_covered_count'];
            $data->parking_open_count = $data3['parking_open_count']; 
        }else{
            $data->parking_covered_count =null;
            $data->parking_open_count =null;
        }
        $data->total_floors = $data3['total_floors'];
        $data->property_on_floor = $data3['property_floor'];
        $data->willing_to_rent_out_to = $data3['willing_to_rent'];
        $data->buildyear = $data3['year_built'];

        // step 4
        $data->inc_electricity_and_water_bill = $data4['electricity_water'];
        $data->expected_rent = $data4['expected_rent'];
        $data->rent_availability =1;
        $data->maintenance_charge_status = $data4['maintenance_charge_status'];
        if($data4['maintenance_charge_status'] == 1){
            $data->maintenance_charge = $data4['maintenance_charge'];
            $data->maintenance_charge_condition =$data4['maintenance_charge_condition'];
        }else{
            $data->maintenance_charge_condition =null;
            $data->maintenance_charge =null;
        }
        $data->negotiable_status=$data4['price_negotiable_status'];
        if($data4['price_negotiable_status'] == 1){
        $data->price_negotiable =$data4['price_negotiable'];
        }else{
           $data->price_negotiable =null;
        }
        $data->security_deposit=$data4['security_deposit'];
        // $data->tax_govt_charge = $data4['tax_govt_charge'];
        $data->draft=$data4['draft_form_id'];
        $data->rent_cond =1;
        $data->video_link = $video_link;
        $data->save();
        $product_id=$request->id;
       $user_id = Auth::user()->id;
 
                if($data3['furnishings']== 1 ){
                    // check amenties
                    $amenities_check=$request->amenties;
                    $length=count($amenities_check);
                    if($length>0){
                        $amenity_delete= ProductAmenties::where(['product_id'=>$product_id,'user_id'=>$user_id])->delete();
                        foreach ($amenities_check as $Check_amenities) {
                            $ProductAmenties = [
                                'amenties' =>$Check_amenities,
                                'product_id' => $product_id,
                                'user_id' =>$user_id
                            ];
                            ProductAmenties::create($ProductAmenties);
                        }
                    }
                }else{
                    //  return $request->amenityDetail;
                    // if($request->amenties){
                        $amenity_delete= ProductAmenties::where(['product_id'=>$product_id,'user_id'=>$user_id])->delete();
                    // }
                }
        return response() -> json([
            'message' => 'Successfully Updated',
            'data' => $data
        ]);

    }



    public function update_product(Request $request)
    {
    
        $request -> validate([
            // 'id' => 'required',
            // // 'view_counter' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'rent_cond' => 'required',
            // 'rent_availability' => 'required',
            // 'sale_availability' => 'required',
            // 'possession_by' => 'required',
            // 'locality' => 'required',
            // 'display_address' => 'required',
            // 'ownership' => 'required',
            // 'expected_pricing' => 'required',
            // 'inclusive_pricing_details' => 'required',
            // 'tax_govt_charge' => 'required',
            // 'price_negotiable' => 'required',
            // 'maintenance_charge_status' => 'required',
            // 'maintenance_charge' => 'required',
            // 'maintenance_charge_condition' => 'required',
            // 'deposit' => 'required',
            // 'available_for' => 'required',
            // 'brokerage_charges' => 'required',
            // 'type' => 'required',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'balconies' => 'required',
            'additional_rooms' => 'required',
            'furnishing_status' => 'required',
            'furnishings' => 'required',
            'total_floors' => 'required',
            'property_on_floor' => 'required',
            'rera_registration_status' => 'required',
            'amenities' => 'required',
            'facing_towards' => 'required',
            'additional_parking_status' => 'required',
            // 'description' => 'required',
            'parking_covered_count' => 'required',
            'parking_open_count' => 'required',
            'availability_condition' => 'required',
            'buildyear' => 'required',
            'expected_rent' => 'required',
            'inc_electricity_and_water_bill' => 'required',
            'security_deposit' => 'required',
            'duration_of_rent_aggreement' => 'required',
            'month_of_notice' => 'required',
            'equipment' => 'required',
            'features' => 'required',
            'nearby_places' => 'required',
            'area' => 'required',
            'area_unit' => 'required',
            'carpet_area' => 'required',
            'property_detail' => 'required',
            'build_name' => 'required',
            'willing_to_rent_out_to' => 'required',
            'agreement_type' => 'required',
            'map_latitude' => 'required',
            'map_longitude' => 'required',
            'delete_flag' => 'required',
        ]);

        $data = product::find($request->id);

        $usertype = Auth::user()->id;

        if($usertype == $data->user_id){
            return response()->json([
                'unauthorised',
            ], 401);
        }

        $data->view_counter = $request->view_counter;
        $data->address = $request->address;
        $data->rent_cond = $request->rent_cond;
        $data->rent_availability = $request->rent_availability;
        $data->sale_availability = $request->sale_availability;
        $data->possession_by = $request->possession_by;
        // $data->locality = $request->locality;
        $data->display_address = $request->display_address;
        $data->ownership = $request->ownership;
        $data->expected_pricing = $request->expected_pricing;
        $data->inclusive_pricing_details = $request->inclusive_pricing_details;
        $data->tax_govt_charge = $request->tax_govt_charge;
        $data->price_negotiable = $request->price_negotiable;
        $data->maintenance_charge_status = $request->maintenance_charge_status;
        $data->maintenance_charge = $request->maintenance_charge;
        $data->maintenance_charge_condition = $request->maintenance_charge_condition;
        $data->deposit = $request->deposit;
        $data->available_for = $request->available_for;
        $data->brokerage_charges = $request->brokerage_charges;
        $data->type = $request->type;
        $data->bedroom = $request->bedroom;
        $data->bathroom = $request->bathroom;
        $data->balconies = $request->balconies;
        $data->additional_rooms = $request->additional_rooms;
        $data->furnishing_status = $request->furnishing_status;
        $data->furnishings = $request->furnishings;
        $data->total_floors = $request->total_floors;
        $data->property_on_floor = $request->property_on_floor;
        $data->rera_registration_status = $request->rera_registration_status;
        $data->amenities = $request->amenities;
        $data->facing_towards = $request->facing_towards;
        $data->additional_parking_status = $request->additional_parking_status;
        // $data->description = $request->description;
        $data->parking_covered_count = $request->parking_covered_count;
        $data->parking_open_count = $request->parking_open_count;
        $data->availability_condition = $request->availability_condition;
        $data->buildyear = $request->buildyear;
        $data->expected_rent = $request->expected_rent;
        $data->inc_electricity_and_water_bill = $request->inc_electricity_and_water_bill;
        $data->security_deposit = $request->security_deposit;
        $data->duration_of_rent_aggreement = $request->duration_of_rent_aggreement;
        $data->month_of_notice = $request->month_of_notice;
        $data->equipment = $request->equipment;
        $data->features = $request->features;
        $data->nearby_places = $request->nearby_places;
        $data->area = $request->area;
        $data->area_unit = $request->area_unit;
        $data->carpet_area = $request->carpet_area;
        $data->property_detail = $request->property_detail;
        $data->build_name = $request->build_name;
        $data->willing_to_rent_out_to = $request->willing_to_rent_out_to;
        $data->agreement_type = $request->agreement_type;
        $data->map_latitude = $request->map_latitude;
        $data->map_longitude = $request->map_longitude;
        $data->delete_flag = $request->delete_flag;

        $data->save();

        return response() -> json([
            'data' => $data
        ]);

    }
    public function property_get_id(Request $request)
    {
        try{
              $request -> validate([
                    'id' => 'required'
                ]);

               $user_id = Auth::user()->id;
                //$product = product::where('id', $request->id)->where('user_id',$user_id)->with('amenities','product_img','Property_Type','locality')->first();
                $product = product::where('id', $request->id)->where('user_id',$user_id)->with('amenities','product_img','product_state','product_district','product_locality','product_sub_locality','property_room')->first();
                    return response()->json([
                        'data' => $product
                    ]);
                    return response()->json([
                        'data' => $product
                    ]);
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
         }       
    }

    public function get_product_details(Request $request) {
        $request -> validate([
            'id' => 'required'
        ]);

        return $product_details = product::where('id', $request->id)->with('Property_area_unit', 'maintenance_condition')->get();
    }

    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }
     public function delete_video(Request $request){

        $request->validate([
            'product_id' => 'required',
            'video'=>'required',
        ]);
        product::where([ 'video_link'=> $request->video,'id'=>$request->product_id ])->update(['video_link' => '']);

        return response()->json([
            'message' => 'Video Successfully deleted',
        ], 201);

    }
}
