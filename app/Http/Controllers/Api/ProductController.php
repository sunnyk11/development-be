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
use App\Models\Product_Comparision;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = product::where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->with('UserDetail','product_img','product_comparision','Property_Type')->orderBy('id', 'desc')->get();
        return response()->json([
            'data' =>$data,
        ], 201);
    }

    public function index_featured()
    {
        $data = product::with('UserDetail','product_img','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->orderBy('id', 'desc')->take(9)->get();
        return response()->json([
            'data' =>$data,
        ], 201);
    }
    public function index_featured_wishlist()
    {
       $user_id = Auth::user()->id;
        $product = product::with('UserDetail','product_img','product_comparision','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->orderBy('id', 'desc')->take(9)->get();

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

    public function product_list_featured()
    {
        $data = product::with('UserDetail','product_img','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->orderBy('id', 'desc')->get();
        return response()->json([
            'data' =>$data,
        ], 201);
    }

 public function product_listing_wishlist()
    {
        $user_id = Auth::user()->id;
        $product = product::with('UserDetail','product_img','product_comparision','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->orderBy('id', 'desc')->get();

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
        $product = product::with('UserDetail','Property_Type','product_img')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0','type'=> $request->id])->get();
        return response()->json([
            'data' =>$product,
          ], 201);
        
    }
    
    public function search_pro_type_login(Request $request)
    {
        // return $request->input('id');
        $product = product::with('UserDetail','Property_Type','product_img','Property_Type','product_comparision')->where(['delete_flag'=> '0','draft'=> '0','type'=> $request->id,'order_status'=> '0'])->get();
        return response()->json([
            'data' =>$product,
          ], 201);
        
    }


    public function propertysearch_list(Request $request)
    {
        // return $request->input();
        // return $request->Bedrooms;
        $product = product::with('amenities','UserDetail','Property_Type','product_img')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->search($request)->get();
        return response()->json([
            'data' =>$product,
          ], 201);
        
    }
    public function feature_property()
    {
        $product = product::with('UserDetail','product_img')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->where('view_counter', '>=',1)->orderBy('view_counter', 'desc')->take(4)->get();

        return response()->json([
            'data' =>$product,
          ]);
        
    }
    public function Recently_view()
    {
        $product = product::with('UserDetail','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->where('view_counter', '>=',1)->orderBy('view_counter', 'desc')->take(4)->get();

        return response()->json([
            'data' =>$product,
          ], 201);
        
    }

     public function search_prod_by_city(Request $request){


        $request->validate([
            'cityValue' => 'required',
        ]);
            $city = $request->cityValue;

        $productSimilar=product::with('UserDetail','Property_Type','product_img')->where(['city'=> $city,'delete_flag'=>0,'draft'=>'0','order_status'=> '0'])->orderBy('id', 'desc')->take(6)->get();

            return response()-> json([
                'product' => $productSimilar,
            ]);

     }
     
     public function loginSimilarproperty(Request $request)
     {
       $city = $request->cityValue;  
        $user_id = Auth::user()->id;
        $product = product::with('UserDetail','product_img','product_comparision','Property_Type')->where(['city'=> $city,'delete_flag'=> 0,'draft'=> '0','order_status'=> '0'])->orderBy('id', 'desc')->take(6)->get();
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
            'product' =>$productArray,
          ], 201);
        }

    }
    public function User_propertysearchlist(Request $request)
    {
        // return $request->input();
       $user_id = Auth::user()->id;
        $product = product::with('UserDetail','amenities','product_img','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->search($request)->orderBy('id', 'desc')->get();
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
        
        
    }

     public function product_login_see(Request $request){


        $request->validate([
            'prod_id' => 'required',
        ]);
            $prod_id = $request->prod_id;

        $user_id = Auth::user()->id;

        // $product_id_func = product::find($prod_id)->productid;
         $product_id_func = product::where(['delete_flag'=> '0','draft'=> '0','id'=>$prod_id])->with('amenities','product_img','product_comparision','Single_wishlist','UserDetail','Property_Type')->orderBy('id', 'desc')->get();

           product::where('id', $request->prod_id)->update(['view_counter' => DB::raw('view_counter + 1')]);;

            return response()-> json([
                'product' => $product_id_func,
            ]);

     }

     public function search_prod_by_id(Request $request){


        $request->validate([
            'prod_id' => 'required',
        ]);
            $prod_id = $request->prod_id;

        // $product_id_func = product::find($prod_id)->productid;
         $product_id_func = product::where((['delete_flag'=> '0','draft'=> '0','id'=>$prod_id,'order_status'=> '0']))->with('amenities','Property_Type','product_img')->get();

        $userid = DB::table('products')->select('user_id')->where("id", $prod_id)->value("value");
        $user_details = DB::table('users')->select('id','name','email','profile_pic')->where('id', $userid)->get();

        product::where('id', $request->prod_id)->update(['view_counter' => DB::raw('view_counter + 1')]);;

            return response()-> json([
                'user_data' => $user_details,
                'product' => $product_id_func,
            ]);

     }


     public function Login_search_home(Request $request)
    {
        $user_id = Auth::user()->id;
        $product = product::with('UserDetail','product_img','product_comparision','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->search($request)->orderBy('id', 'desc')->get();
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
        $product = product::with('UserDetail','product_img','Property_Type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->search($request)->get();
        return response()->json([
            'data' =>$product,
          ], 201);
     }
    public function city_search_func(Request $request){
        $request->validate([
            'city' => 'required'
        ]);
        $prod_query3 = $request->city;


        // $needles = explode(',', $q);

        // In my case, I wanted to split the string when a comma or a whitespace is found:
        // $needles = preg_split('/[\s,]+/', $q);

        // $products = product::where('build_name', 'LIKE', "%{$q}%");

        $products = product::Where(['city' => $prod_query3 , 'delete_flag' => 0,'draft'=> '0','order_status'=> '0']);


        // foreach ($needles as $needle) {
        //     $products = $products->orWhere('build_name', 'LIKE', "%{$needle}%");
        // }

        $products = $products->Latest()->paginate(150);

        return response()-> json([
            'product' => $products,
        ]);
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
      if($request->draft_form_id){
        $product = product::where('id', $request->draft_form_id)->with('amenities')->first();

        $data = product::find($request->draft_form_id);

        $usertype = Auth::user()->usertype;

        $product_id=$request->draft_form_id;
        $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$request->video_link);
      
         $additional_rooms=implode(',',$request->additional_rooms);
         // return $additional_rooms;
        // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);

       // product images functionalty
        if($db_img_length<5){
            $product_image= $request->input('product_image');
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
        // $product_uid= rand (10,100).time();

        // $data->product_uid= $product_uid;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->rent_cond = $request->rent_cond;
        $data->possession_by = $request->possession_by;
        $data->locality = $request->locality;
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
        $data->brokerage_charges = $request->brokerage_charges;
        $data->type = $request->type;
        $data->bedroom = $request->bedroom;
        $data->bathroom = $request->bathroom;
        $data->balconies = $request->balconies;
        $data->additional_rooms =$additional_rooms;
        $data->additional_rooms_status=$request->additional_rooms_status;
        $data->furnishing_status = $request->furnishing_status;
        $data->furnishings = $request->furnishings;
        $data->total_floors = $request->total_floors;
        $data->property_on_floor = $request->property_on_floor;
        $data->rera_registration_status = $request->rera_registration_status;
        // $data->amenities = $request->amenities;
        $data->facing_towards = $request->facing_towards;
        $data->additional_parking_status = $request->additional_parking_status;
        // $data->description = $request->description;
        $data->parking_covered_count = $request->parking_covered_count;
        $data->parking_open_count = $request->parking_open_count;
        $data->availability_condition = $request->availability_condition;
        $data->buildyear = $request->buildyear;
        $data->month_of_notice = $request->month_of_notice;
        $data->equipment = $request->equipment;
        $data->features = $request->features;
        $data->nearby_places = $request->nearby_places;
        $data->area = $request->area;
        $data->area_unit = $request->area_unit;
        $data->carpet_area = $request->carpet_area;
        $data->property_detail = $request->property_detail;
        $data->build_name = $request->build_name;
        $data->nearest_landmark = $request->nearest_landmark;
        $data->map_latitude = $request->map_latitude;
        $data->map_longitude = $request->map_longitude;
        $data->video_link = $video_link;
        $data->pincode=$request->pincode;
        $data->negotiable_status=$request->negotiable_status;
        $data->draft=$request->draft;
        $data->save();
       // check amenties
       $amenities=$request->amenities;
       $length=count($amenities);
       if($length>0){
           for($i=0; $i<$length;$i++){
                $ProductAmenties = [
                    'amenties' =>$amenities[$i],
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
                'message' => 'Draft Sales Property For Updated',
                'last_id' => $request->draft_form_id,
        ]);
        }else{
           $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$request->video_link);
         $addtional_room=implode(',',$request->additional_rooms);

        $product_uid= rand (10,100).time();

        $product_data = new Product([
            'product_uid' => $product_uid,
            'user_id' => $user_id,
            'build_name' => $request->build_name,
            'type' => $request->type,
            'address' => $request->address,
            'city' => $request->city,
            'locality' => $request->locality,
            'pincode' => $request->pincode,
            'property_detail' => $request->property_detail,
            'nearest_landmark' => $request->nearest_landmark,
            'map_latitude' => $request->map_latitude,
            'map_longitude' => $request->map_longitude,
            'display_address' => $request->display_address,
            'area' => $request->area,
            'area_unit' => $request->area_unit,
            'carpet_area' => $request->carpet_area,
            'bedroom' => $request->bedroom,
            'bathroom' => $request->bathroom,
            'balconies' => $request->balconies,
            'additional_rooms_status'=>$request->additional_rooms_status,
            'additional_rooms' => $addtional_room,
            'furnishing_status' => $request->furnishing_status,
            'furnishings' => json_encode($request->furnishings),
            'total_floors' => $request->total_floors,
            'property_on_floor' => $request->property_on_floor,
            'rera_registration_status' => $request->rera_registration_status,
            'additional_parking_status' => $request->additional_parking_status,
            'parking_covered_count' => $request->parking_covered_count,
            'parking_open_count' => $request->parking_open_count,
            'sale_availability' => $request->sale_availability,
            'possession_by' => $request->possession_by,
            'ownership' => $request->ownership,
            'expected_pricing' => $request->expected_pricing,
            'inclusive_pricing_details' => $request->inclusive_pricing_details,
            'tax_govt_charge' => $request->tax_govt_charge,
            'price_negotiable' => $request->price_negotiable,
            'negotiable_status' => $request->negotiable_status,
            'maintenance_charge_status' => $request->maintenance_charge_status,
            'maintenance_charge' => $request->maintenance_charge,
            'maintenance_charge_condition' => $request->maintenance_charge_condition,
            'deposit' => $request->deposit,
            'brokerage_charges' => $request->brokerage_charges,
            'facing_towards' => $request->facing_towards,
            'availability_condition' => $request->availability_condition,
            // 'amenities' => json_encode($request->amenities),
            'buildyear' => $request->buildyear,
            // 'description' => $request->description,
            'equipment' => $request->equipment,
            'features' => $request->features,
            'nearby_places' => $request->nearby_places,
            'video_link'=>$video_link,
            'draft' => $request->draft,
        ]);
        $user_type = Auth::user()->usertype;

        if ($user_type == 1)
            return response()->json([
                'message' => 'Unauthorised User',
            ], 401); 
        $product_data->save();
        $lastid=$product_data->id;
        eventtracker::create(['symbol_code' => '8', 'event' => Auth::user()->name.' created a new property listing for sale.']);

       
         $product_id=$product_data->id;
         // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);
         
        // product images functionalty
        if($db_img_length<5){
           $product_image= $request->input('product_image');
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

           $user_id = Auth::user()->id;
           $amenities=$request->amenities;
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
                'message' => 'Sales Property Successfully created',
                'last_id' => $lastid,
            ], 201);
         
        }
    }

    public function second(Request $request)
    {
      if($request->draft_form_id){
        $product = product::where('id', $request->draft_form_id)->with('amenities')->first();
        $data = product::find($request->draft_form_id);

        $usertype = Auth::user()->usertype;
            
        $product_id=$request->draft_form_id;
       $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$request->video_link);

       
         $additional_rooms=implode(',',$request->additional_rooms);
         // return $additional_rooms;
         // return $additional_rooms;
        // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);

       // product images functionalty
        if($db_img_length<5){
            $product_image= $request->input('product_image');
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
       // $product_uid= rand (10,100).time();

       //  $data->product_uid = $product_uid;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->rent_cond = $request->rent_cond;
        $data->rent_availability = $request->rent_availability;
        $data->sale_availability = $request->sale_availability;
        $data->possession_by = $request->possession_by;
        $data->locality = $request->locality;
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
        $data->additional_rooms = $additional_rooms;
        $data->additional_rooms_status=$request->additional_rooms_status;
        $data->furnishing_status = $request->furnishing_status;
        $data->furnishings = $request->furnishings;
        $data->total_floors = $request->total_floors;
        $data->property_on_floor = $request->property_on_floor;
        $data->rera_registration_status = $request->rera_registration_status;
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
        $data->nearby_places = $request->nearby_places;
        $data->area = $request->area;
        $data->area_unit = $request->area_unit;
        $data->property_detail = $request->property_detail;
        $data->build_name = $request->build_name;
        $data->willing_to_rent_out_to = $request->willing_to_rent_out_to;
        $data->agreement_type = $request->agreement_type;
        $data->nearest_landmark = $request->nearest_landmark;
        $data->map_latitude = $request->map_latitude;
        $data->map_longitude = $request->map_longitude;
        $data->video_link = $video_link;
        $data->pincode=$request->pincode;
        $data->draft=$request->draft;
        $data->negotiable_status=$request->negotiable_status;
              $Product_Data = [
                 'address'=> $data->address,
                 'city'=>  $data->city,
                 'rent_cond' =>$data->rent_cond,
                 'possession_by'=> $data->possession_by,
                 'locality' =>$data->locality,
                 'pincode' =>$data->pincode,
                 'display_address' =>$data->display_address,
                 'ownership'=>$data->ownership,
                 'expected_pricing' =>$data->expected_pricing,
                 'inclusive_pricing_details'=>$data->inclusive_pricing_details,
                 'tax_govt_charge'=>$data->tax_govt_charge ,
                 'price_negotiable'=>$data->price_negotiable,
                 'maintenance_charge_status'=>$data->maintenance_charge_status,
                 'maintenance_charge'=>$data->maintenance_charge,
                 'maintenance_charge_condition'=>$data->maintenance_charge_condition,
                 'deposit'=>$data->deposit,
                 'available_for'=>$data->available_for,
                 'brokerage_charges'=>$data->brokerage_charges,
                 'type'=> $data->type,
                 'bedroom'=>$data->bedroom,
                 'bathroom'=> $data->bathroom,
                 'balconies'=> $data->balconies,
                 'additional_rooms_status'=> $data->additional_rooms_status,
                 'additional_rooms'=> $data->additional_rooms,
                 'furnishing_status'=>$data->furnishing_status,
                 'furnishings'=>$data->furnishings,
                 'total_floors'=>$data->total_floors,
                 'property_on_floor'=>$data->property_on_floor,
                 'rera_registration_status'=>$data->rera_registration_status,
                 'facing_towards'=>$data->facing_towards,
                 // 'description'=> $data->description,
                 'additional_parking_status'=>$data->additional_parking_status,
                 'parking_covered_count'=>$data->parking_covered_count,
                 'parking_open_count'=>$data->parking_open_count,
                 'availability_condition'=>$data->availability_condition,
                 'buildyear'=> $data->buildyear ,
                 'expected_rent'=>$data->expected_rent,
                 'inc_electricity_and_water_bill'=>$data->inc_electricity_and_water_bill,
                 'security_deposit'=> $data->security_deposit,
                 'duration_of_rent_aggreement'=>$data->duration_of_rent_aggreement,
                 'month_of_notice'=>$data->month_of_notice,
                 'nearby_places'=>$data->nearby_places,
                 'area'=>$data->area,
                 'area_unit'=>$data->area_unit,
                 'property_detail'=>$data->property_detail,
                 'build_name'=>$data->build_name ,
                 'willing_to_rent_out_to'=>$data->willing_to_rent_out_to,
                 'agreement_type'=>$data->agreement_type,
                 'nearest_landmark'=>$data->nearest_landmark,
                 'map_latitude'=> $data->map_latitude,
                 'map_longitude'=> $data->map_longitude,
                 'video_link'=>  $data->video_link,
                 'negotiable_status'=> $data->negotiable_status,
                 'draft'=>$data->draft,
            ];  

        $data->save();
        $product_id=$request->draft_form_id;
       $user_id = Auth::user()->id;
       // check amenties 
       $amenities_check=$request->amenities;
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
                'message' => 'Draft Rent Property For Updated',
                'last_id' => $request->draft_form_id,
        ]);
      }else{
        $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$request->video_link);
         $addtional_room=implode(',',$request->additional_rooms);
           
         $product_uid= rand (10,100).time();

            $product_data = new Product([
            'user_id' => $user_id ,
            'product_uid' => $product_uid,
            'build_name' => $request->build_name ,
            'type' => $request->type ,
            'willing_to_rent_out_to' => $request->willing_to_rent_out_to ,
            'agreement_type' => $request->agreement_type ,
            'address' => $request->address ,
            'display_address' => $request->display_address ,
            'city' => $request->city ,
            'locality' => $request->locality ,
            'property_detail' => $request->property_detail ,
            'nearest_landmark' => $request->nearest_landmark ,
            'map_latitude' => $request->map_latitude ,
            'map_longitude' => $request->map_longitude ,
            'nearby_places' => $request->nearby_places ,
            'area' => $request->area ,
            'area_unit' => $request->area_unit ,
            'carpet_area' => $request->carpet_area ,
            'bedroom' => $request->bedroom ,
            'bathroom' => $request->bathroom ,
            'balconies' => $request->balconies ,
            'additional_rooms' => $request->additional_rooms ,
            'furnishing_status' => $request->furnishing_status ,
            //'furnishings' => json_encode($request->furnishings) ,
            'total_floors' => $request->total_floors ,
            'property_on_floor' => $request->property_on_floor ,
            'rera_registration_status' => $request->rera_registration_status ,
            'additional_parking_status' => $request->additional_parking_status ,
            'parking_covered_count' => $request->parking_covered_count ,
            'parking_open_count' => $request->parking_open_count ,
            'rent_availability' => $request->rent_availability ,
            'available_for' => $request->available_for ,
            'buildyear' => $request->buildyear ,
            'possession_by' => $request->possession_by ,
            'duration_of_rent_aggreement' => $request->duration_of_rent_aggreement ,
            'security_deposit' => $request->security_deposit ,
            'maintenance_charge' =>$request->maintenance_charge,
            'maintenance_charge_status' => $request->maintenance_charge_status ,
            //'maintenance_charge_condition' => $request->maintenance_charge_condition ,
            'ownership' => $request->ownership ,
            'rent_cond' => $request->rent_cond ,
            'tax_govt_charge' => $request->tax_govt_charge ,
            'price_negotiable' => $request->price_negotiable,
            'negotiable_status' => $request->negotiable_status,
            //'deposit' => $request->deposit ,
            'brokerage_charges' => $request->brokerage_charges ,
            'facing_towards' => $request->facing_towards ,
            'availability_condition' => $request->availability_condition ,
            'expected_rent' => $request->expected_rent ,
            'inc_electricity_and_water_bill' => $request->inc_electricity_and_water_bill ,
            'pincode' => $request->pincode,
            'equipment' => $request->equipment ,
            'additional_rooms' => $addtional_room,
            'additional_rooms_status' => $request->additional_rooms_status,
            //'description' => $request->description ,
            'video_link'=>$video_link,
            'draft' => $request->draft,
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
           $product_image= $request->input('product_image');
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

           $amenities=$request->amenities;
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
                'message' => 'Rent Property Successfully created',
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

         // product img delete
       //  $product_img=Product_img::select('image')->where('product_id', $request->product_id)->get();
       //  $img_lenght=count($product_img);

       // if($img_lenght>0){
       //      for ($i=0; $i<$img_lenght ; $i++) { 
       //       $image_path='storage/'.$product_img[$i]['image'];
       //        unlink($image_path);
       //      }
       //  }
        // product::where('id', $request->product_id)->delete();

        product::where('id', $request->product_id)->update(['delete_flag' => 1 ]);

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

        $user_id = Auth::user()->id;

        $data = product::with('product_img')->where('user_id', $user_id)->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0'])->orderBy('id', 'desc')->get();
        //$tableq = DB::table('users')->select('id','name','email','profile_pic')->get();
        return response()->json([
            //'users'=> $tableq,
            'data' =>$data,
        ], 200);

    }
    public function Draft_properties()
    {

        $user_id = Auth::user()->id;

        $data = product::with('product_img')->where(['delete_flag'=> '0','draft'=> '1','order_status'=> '0','user_id'=>  $user_id])->orderBy('id', 'desc')->get();
        return response()->json([
            'data' =>$data,
        ], 200);

    }

    public function dashboard_indexer(){

        $id = Auth::user()->id;
        $views = product::select('view_counter')->where('user_id', $id)->get()->sum('view_counter');

        $property_count = product::where('user_id', $id)->get()->count();


        return response()->json([
            'view_count' => $views,
            'property_count' => $property_count,
        ], 200);
    }
 public function update_Sales_product(Request $request){
        $request -> validate([
            'id' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'possession_by' => 'required',
            // 'locality' => 'required',
            // 'display_address' => 'required',
            // 'tax_govt_charge' => 'required',
            // 'price_negotiable' => 'required',
            // 'type' => 'required',
            // 'bedroom' => 'required',
            // 'bathroom' => 'required',
            // 'balconies' => 'required',
            // 'additional_rooms' => 'required',
            // 'total_floors' => 'required',
            // 'property_on_floor' => 'required',
            // 'rera_registration_status' => 'required',
            // 'facing_towards' => 'required',
            // 'additional_parking_status' => 'required',
            // // 'description' => 'required',
            // 'availability_condition' => 'required',
            // 'buildyear' => 'required',
            // 'equipment' => 'required',
            // 'features' => 'required',
            // 'area' => 'required',
            // 'area_unit' => 'required',
            // 'carpet_area' => 'required',
            // 'property_detail' => 'required',
            // 'build_name' => 'required',
            // 'nearest_landmark' => 'required',
        ]);
        $product = product::where('id', $request->id)->with('amenities')->first();

        

        $data = product::find($request->id);

        $usertype = Auth::user()->usertype;

        // if($usertype <6 ){
        //     return response()->json([
        //         'unauthorised',
        //     ], 401);
        // }


        $product_id=$request->id;
       $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$request->video_link);
      
         $additional_rooms=implode(',',$request->additional_rooms);
         // return $additional_rooms;
        // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);

       // product images functionalty
        if($db_img_length<5){
            $product_image= $request->input('product_image');
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

        $data->address = $request->address;
        $data->city = $request->city;
        $data->rent_cond = $request->rent_cond;
        $data->possession_by = $request->possession_by;
        $data->locality = $request->locality;
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
        $data->brokerage_charges = $request->brokerage_charges;
        $data->type = $request->type;
        $data->bedroom = $request->bedroom;
        $data->bathroom = $request->bathroom;
        $data->balconies = $request->balconies;
        $data->additional_rooms =$additional_rooms;
        $data->additional_rooms_status=$request->additional_rooms_status;
        $data->furnishing_status = $request->furnishing_status;
        $data->furnishings = $request->furnishings;
        $data->total_floors = $request->total_floors;
        $data->property_on_floor = $request->property_on_floor;
        $data->rera_registration_status = $request->rera_registration_status;
        // $data->amenities = $request->amenities;
        $data->facing_towards = $request->facing_towards;
        $data->additional_parking_status = $request->additional_parking_status;
        // $data->description = $request->description;
        $data->parking_covered_count = $request->parking_covered_count;
        $data->parking_open_count = $request->parking_open_count;
        $data->availability_condition = $request->availability_condition;
        $data->buildyear = $request->buildyear;
        $data->month_of_notice = $request->month_of_notice;
        $data->equipment = $request->equipment;
        $data->features = $request->features;
        $data->nearby_places = $request->nearby_places;
        $data->area = $request->area;
        $data->area_unit = $request->area_unit;
        $data->carpet_area = $request->carpet_area;
        $data->property_detail = $request->property_detail;
        $data->build_name = $request->build_name;
        $data->nearest_landmark = $request->nearest_landmark;
        $data->map_latitude = $request->map_latitude;
        $data->map_longitude = $request->map_longitude;
        $data->video_link = $video_link;
        $data->pincode=$request->pincode;
        $data->negotiable_status=$request->negotiable_status;
        $data->draft=$request->draft;

        $data->save();



       // uncheck Amenties
       $amenity_Uncheck=$request->amenity_Uncheck;
       $Uncheck_length=count($amenity_Uncheck);
       if($Uncheck_length>0){
           for($i=0; $i<$Uncheck_length;$i++){
                $Uncheck_Amenties = [
                    'amenties' =>$amenity_Uncheck[$i],
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


       // check amenties
       $amenities=$request->amenities;
       $length=count($amenities);
       if($length>0){
           for($i=0; $i<$length;$i++){
                $ProductAmenties = [
                    'amenties' =>$amenities[$i],
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
            'data' => $data
        ]);

    }
     public function update_Rent_product(Request $request)
    {
        $request -> validate([
            'id' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'possession_by' => 'required',
            // 'locality' => 'required',
            // 'display_address' => 'required',
            // 'tax_govt_charge' => 'required',
            // 'price_negotiable' => 'required',
            // 'available_for' => 'required',
            // 'type' => 'required',
            // 'bedroom' => 'required',
            // 'bathroom' => 'required',
            // 'balconies' => 'required',
            // 'additional_rooms' => 'required',
            // // 'furnishing_status' => 'required',
            // 'total_floors' => 'required',
            // 'property_on_floor' => 'required',
            // 'rera_registration_status' => 'required',
            // 'facing_towards' => 'required',
            // 'additional_parking_status' => 'required',
            // // 'description' => 'required',
            // 'availability_condition' => 'required',
            // 'buildyear' => 'required',
            // // 'age_of_property' => 'required',
            // 'expected_rent' => 'required',
            // 'inc_electricity_and_water_bill' => 'required',
            // 'security_deposit' => 'required',
            // 'duration_of_rent_aggreement' => 'required',
            // 'month_of_notice' => 'required',
            // 'equipment' => 'required',
            // 'features' => 'required',
            // 'area' => 'required',
            // 'area_unit' => 'required',
            // 'carpet_area' => 'required',
            // 'property_detail' => 'required',
            // 'build_name' => 'required',
            // 'willing_to_rent_out_to' => 'required',
            // 'agreement_type' => 'required',
            // 'nearest_landmark' => 'required',
        ]);
        $product = product::where('id', $request->id)->with('amenities')->first();

        $data = product::find($request->id);

        $usertype = Auth::user()->usertype;

        // if($usertype <6 ){
        //     return response()->json([
        //         'unauthorised',
        //     ], 401);
        // }
            
        $product_id=$request->id;
       $user_id = Auth::user()->id;
        $video_link=str_replace("https://www.youtube.com/watch?v=","",$request->video_link);

       
         $additional_rooms=implode(',',$request->additional_rooms);
         // return $additional_rooms;
         // return $additional_rooms;
        // inserted images functionalty
        $DB_img=Product_img::where('user_id', $user_id)->where('product_id',
            $product_id)->get();
        $db_img_length=count($DB_img);

       // product images functionalty
        if($db_img_length<5){
            $product_image= $request->input('product_image');
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

        // $data->view_counter = $request->view_counter;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->rent_cond = $request->rent_cond;
        $data->rent_availability = $request->rent_availability;
        $data->sale_availability = $request->sale_availability;
        $data->possession_by = $request->possession_by;
        $data->locality = $request->locality;
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
        $data->additional_rooms = $additional_rooms;
        $data->additional_rooms_status=$request->additional_rooms_status;
        $data->furnishing_status = $request->furnishing_status;
        $data->furnishings = $request->furnishings;
        $data->total_floors = $request->total_floors;
        $data->property_on_floor = $request->property_on_floor;
        $data->rera_registration_status = $request->rera_registration_status;
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
        $data->nearby_places = $request->nearby_places;
        $data->area = $request->area;
        $data->area_unit = $request->area_unit;
        $data->property_detail = $request->property_detail;
        $data->build_name = $request->build_name;
        $data->willing_to_rent_out_to = $request->willing_to_rent_out_to;
        $data->agreement_type = $request->agreement_type;
        $data->nearest_landmark = $request->nearest_landmark;
        $data->map_latitude = $request->map_latitude;
        $data->map_longitude = $request->map_longitude;
        $data->video_link = $video_link;
        $data->pincode=$request->pincode;
        $data->negotiable_status=$request->negotiable_status;
        $data->draft=$request->draft;
              $Product_Data = [
                 'address'=> $data->address,
                 'city'=>  $data->city,
                 'rent_cond' =>$data->rent_cond,
                 'possession_by'=> $data->possession_by,
                 'locality' =>$data->locality,
                 'pincode' =>$data->pincode,
                 'display_address' =>$data->display_address,
                 'ownership'=>$data->ownership,
                 'expected_pricing' =>$data->expected_pricing,
                 'inclusive_pricing_details'=>$data->inclusive_pricing_details,
                 'tax_govt_charge'=>$data->tax_govt_charge ,
                 'price_negotiable'=>$data->price_negotiable,
                 'maintenance_charge_status'=>$data->maintenance_charge_status,
                 'maintenance_charge'=>$data->maintenance_charge,
                 'maintenance_charge_condition'=>$data->maintenance_charge_condition,
                 'deposit'=>$data->deposit,
                 'available_for'=>$data->available_for,
                 'brokerage_charges'=>$data->brokerage_charges,
                 'type'=> $data->type,
                 'bedroom'=>$data->bedroom,
                 'bathroom'=> $data->bathroom,
                 'balconies'=> $data->balconies,
                 'additional_rooms_status'=> $data->additional_rooms_status,
                 'additional_rooms'=> $data->additional_rooms,
                 'furnishing_status'=>$data->furnishing_status,
                 'furnishings'=>$data->furnishings,
                 'total_floors'=>$data->total_floors,
                 'property_on_floor'=>$data->property_on_floor,
                 'rera_registration_status'=>$data->rera_registration_status,
                 'facing_towards'=>$data->facing_towards,
                 // 'description'=> $data->description,
                 'additional_parking_status'=>$data->additional_parking_status,
                 'parking_covered_count'=>$data->parking_covered_count,
                 'parking_open_count'=>$data->parking_open_count,
                 'availability_condition'=>$data->availability_condition,
                 'buildyear'=> $data->buildyear ,
                 'expected_rent'=>$data->expected_rent,
                 'inc_electricity_and_water_bill'=>$data->inc_electricity_and_water_bill,
                 'security_deposit'=> $data->security_deposit,
                 'duration_of_rent_aggreement'=>$data->duration_of_rent_aggreement,
                 'month_of_notice'=>$data->month_of_notice,
                 'nearby_places'=>$data->nearby_places,
                 'area'=>$data->area,
                 'area_unit'=>$data->area_unit,
                 'property_detail'=>$data->property_detail,
                 'build_name'=>$data->build_name ,
                 'willing_to_rent_out_to'=>$data->willing_to_rent_out_to,
                 'agreement_type'=>$data->agreement_type,
                 'nearest_landmark'=>$data->nearest_landmark,
                 'map_latitude'=> $data->map_latitude,
                 'map_longitude'=> $data->map_longitude,
                 'video_link'=>  $data->video_link,
                 'negotiable_status'=> $data->negotiable_status,
                 'draft'=> $data->draft,
            ];  

        $data->save();
        $product_id=$request->id;
       $user_id = Auth::user()->id;

       // uncheck Amenties
       $amenity_Uncheck=$request->amenity_Uncheck;
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


       // check amenties
       $amenities_check=$request->amenities;
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
            // 'product_image1' => 'required',
            // 'product_image2' => 'required',
            // 'product_image3' => 'required',
            // 'product_image4' => 'required',
            // 'product_image5' => 'required',
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
            'nearest_landmark' => 'required',
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
        $data->city = $request->city;
        $data->rent_cond = $request->rent_cond;
        $data->rent_availability = $request->rent_availability;
        $data->sale_availability = $request->sale_availability;
        $data->possession_by = $request->possession_by;
        $data->locality = $request->locality;
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
        $data->product_image1 = $request->product_image1;
        $data->product_image2 = $request->product_image2;
        $data->product_image3 = $request->product_image3;
        $data->product_image4 = $request->product_image4;
        $data->product_image5 = $request->product_image5;
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
        $data->nearest_landmark = $request->nearest_landmark;
        $data->map_latitude = $request->map_latitude;
        $data->map_longitude = $request->map_longitude;
        $data->delete_flag = $request->delete_flag;

        $data->save();

        return response() -> json([
            'data' => $data
        ]);

    }
    public function Propery_get_id(Request $request)
    {
      $request -> validate([
            'id' => 'required'
        ]);

       $user_id = Auth::user()->id;
        $product = product::where('id', $request->id)->where('user_id',$user_id)->with('amenities','product_img','Property_Type','locality')->first();
       
       if($product){
            return response()->json([
                'data' => $product
            ]);
       }else{
            $product=['id'=>0];
            return response()->json([
                'data' => $product
            ]);
        }
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
}
