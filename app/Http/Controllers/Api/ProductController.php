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
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = product::where('delete_flag', 0)->with('UserDetail')->Latest()->paginate();
        return response()->json([
            'data' =>$data,
        ], 201);
    }

    public function index_featured()
    {
        $data = product::with('UserDetail')->where('delete_flag', 0)->Latest()->paginate(50);
        return response()->json([
            'data' =>$data,
        ], 201);
    }
    public function index_featured_wishlist()
    {
        $user_id = Auth::user()->id;
        $product = product::with('UserDetail')->where('delete_flag', 0)->Latest()->paginate(50);
        $Wishlist=Wishlist::where('user_id', $user_id)->orderBy('id', 'asc')->get();
        $productcount = count($product);
        $wishlistcount = count($Wishlist);

       $productArray = json_decode(json_encode($product), true);
       $WishlistArray = json_decode(json_encode($Wishlist), true);
       
       // wishlist check with product id nd wishlist id
       for ($i=0; $i < $productcount; $i++) {    
            for ($j=0; $j < $wishlistcount; $j++) { 
                if($productArray['data'][$i]['id']==$WishlistArray[$j]['product_id']){
                    $addWishlist="true";
                    array_push($productArray['data'][$i],$addWishlist);
                }
            }
        }
        if($productArray['data']){
            return response()->json([
            'data' =>$productArray['data'],
          ], 201);
        }else{
            return response()->json([
            'data' =>$product,
          ], 201);
        }
    }


    public function propertysearch_list(Request $request)
    {
        $product = product::with('UserDetail')->where('delete_flag', 0)->search($request)->get();
        return response()->json([
            'data' =>$product,
          ], 201);
        
    }
    public function Recently_view()
    {
        $product = product::with('UserDetail')->where('delete_flag', 0)->where('view_counter', '>=',1)->orderBy('view_counter', 'desc')->take(4)->get();

        return response()->json([
            'data' =>$product,
          ], 201);
        
    }

     public function search_prod_by_city(Request $request){


        $request->validate([
            'cityValue' => 'required',
        ]);
            $city = $request->cityValue;

        $productSimilar=product::with('UserDetail')->where('city', $city)->orderBy('id', 'desc')->take(6)->get();

            return response()-> json([
                'product' => $productSimilar,
            ]);

     }
     
     public function loginSimilarproperty(Request $request)
     {
        $city = $request->cityValue;  
        $user_id = Auth::user()->id;
        $product = product::with('UserDetail')->where('city', $city)->orderBy('id', 'desc')->take(6)->get();
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
        $user_id = Auth::user()->id;
        $product = product::with('UserDetail')->where('delete_flag', 0)->search($request)->get();
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

     public function search_prod_by_id(Request $request){


        $request->validate([
            'prod_id' => 'required',
        ]);
            $prod_id = $request->prod_id;

        // $product_id_func = product::find($prod_id)->productid;
         $product_id_func = product::where('id', $prod_id)->with('amenities')->get();

        $userid = DB::table('products')->select('user_id')->where("id", $prod_id)->value("value");
        $user_details = DB::table('users')->select('id','name','email','profile_pic')->where('id', $userid)->get();

        product::where('id', $request->prod_id)->update(['view_counter' => DB::raw('view_counter + 1')]);;

            return response()-> json([
                'user_data' => $user_details,
                'product' => $product_id_func,
            ]);

     }

     public function search_func(Request $request){

        
        $product = product::with('UserDetail')->where('delete_flag', 0)->search($request)->get();
        return response()->json([
            'product' =>$product,
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

        $products = product::Where(['city' => $prod_query3 , 'delete_flag' => 0]);


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



    public function first(Request $request)
    {
        $request -> validate([
            'build_name' => 'required',
            'type' => 'required',
            'address' => 'required' ,
            'city' => 'required' ,
            'locality' => 'required' ,
            'property_detail' => 'required' ,
            'nearest_landmark' => 'required' ,
            'map_latitude' => '' ,
            'map_longitude' => '' ,
            'display_address' => 'required' ,
            // 'product_image1' => 'required' ,
            // 'product_image2' => 'required' ,
            // 'product_image3' => 'required' ,
            // 'product_image4' => 'required' ,
            // 'product_image5' => 'required' ,
            'area' => 'required' ,
            'area_unit' => 'required' ,
            'carpet_area' => 'required' ,
            'bedroom' => 'required' ,
            'bathroom' => 'required' ,
            'balconies' => 'required' ,
            'additional_rooms' => 'required' ,
            'furnishing_status' => 'required' ,
            'furnishings' => '' ,
            'total_floors' => 'required' ,
            'property_on_floor' => 'required' ,
            'rera_registration_status' => 'required' ,
            'additional_parking_status' => 'required' ,
            'parking_covered_count' => '' ,
            'parking_open_count' => '' ,
            'sale_availability' => '' ,
            'possession_by' => 'required' ,
            'maintenance_charge' => '' ,
            'maintenance_charge_status' => '' ,
            'maintenance_charge_condition' => '' ,
            'ownership' => '' ,
            'expected_pricing' => 'required' ,
            'inclusive_pricing_details' => '' ,
            'tax_govt_charge' => 'required' ,
            'price_negotiable' => 'required' ,
            'deposit' => '' ,
            'brokerage_charges' => '' ,
            'facing_towards' => 'required' ,
            'availability_condition' => 'required' ,
            // 'amenities' => 'required' ,
            'buildyear' => 'required' ,
            'age_of_property' => 'required' ,
            'description' => 'required' ,
            'equipment' => 'required' ,
            'features' => 'required' ,
            'nearby_places' => 'required' ,
        ]);
     $imageName1=null;     
    if($request->input('product_image1') != null){
            $base64_image1 = $request->input('product_image1'); // your base64 encoded
            @list($type, $file_data1) = explode(';', $base64_image1);
            @list(, $file_data1) = explode(',', $file_data1);
            $imageName1 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName1, base64_decode($file_data1));
    }

    $imageName2=null;
    if($request->input('product_image2') != null){
        $base64_image2 = $request->input('product_image2'); // your base64 encoded
        @list($type, $file_data2) = explode(';', $base64_image2);
        @list(, $file_data2) = explode(',', $file_data2);
        $imageName2 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put($imageName2, base64_decode($file_data2));
    }

   $imageName3=null;
    if($request->input('product_image3') != null){
        $base64_image3 = $request->input('product_image3'); // your base64 encoded
        @list($type, $file_data3) = explode(';', $base64_image3);
        @list(, $file_data3) = explode(',', $file_data3);
        $imageName3 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put($imageName3, base64_decode($file_data3));
    }
    $imageName4=null;
    if($request->input('product_image4') != null){
        $base64_image4 = $request->input('product_image4'); // your base64 encoded
        @list($type, $file_data4) = explode(';', $base64_image4);
        @list(, $file_data4) = explode(',', $file_data4);
        $imageName4 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put($imageName4, base64_decode($file_data4));
    }
    $imageName5=null;
    if($request->input('product_image5') != null){
        $base64_image5 = $request->input('product_image5'); // your base64 encoded
        @list($type, $file_data5) = explode(';', $base64_image5);
        @list(, $file_data5) = explode(',', $file_data5);
        $imageName5 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put($imageName5, base64_decode($file_data5));
    }
        $user_id = Auth::user()->id;

        $product_data = new Product([
            'user_id' => $user_id,
            'build_name' => $request->build_name,
            'type' => $request->type,
            'address' => $request->address,
            'city' => $request->city,
            'locality' => $request->locality,
            'property_detail' => $request->property_detail,
            'nearest_landmark' => $request->nearest_landmark,
            'map_latitude' => $request->map_latitude,
            'map_longitude' => $request->map_longitude,
            'display_address' => $request->display_address,
            'product_image1' => $imageName1,
            'product_image2' => $imageName2,
            'product_image3' => $imageName3,
            'product_image4' => $imageName4,
            'product_image5' => $imageName5,
            'area' => $request->area,
            'area_unit' => $request->area_unit,
            'carpet_area' => $request->carpet_area,
            'bedroom' => $request->bedroom,
            'bathroom' => $request->bathroom,
            'balconies' => $request->balconies,
            'additional_rooms' => $request->additional_rooms,
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
            'maintenance_charge_status' => $request->maintenance_charge_status,
            'maintenance_charge' => $request->maintenance_charge,
            'maintenance_charge_condition' => $request->maintenance_charge_condition,
            'deposit' => $request->deposit,
            'brokerage_charges' => $request->brokerage_charges,
            'facing_towards' => $request->facing_towards,
            'availability_condition' => $request->availability_condition,
            // 'amenities' => json_encode($request->amenities),
            'buildyear' => $request->buildyear,
            'age_of_property' => $request->age_of_property,
            'description' => $request->description,
            'equipment' => $request->equipment,
            'features' => $request->features,
            'nearby_places' => $request->nearby_places,
        ]);
        $user_type = Auth::user()->usertype;

        if ($user_type == 1)
            return response()->json([
                'message' => 'Unauthorised User',
            ], 401);

        $product_data-> save();
        eventtracker::create(['symbol_code' => '8', 'event' => Auth::user()->name.' created a new property listing for sale.']);

         $product_id=$product_data->id;
           $user_id = Auth::user()->id;
           $amenities=$request->amenities;
           $length=count($amenities);
           for($i=0; $i<$length;$i++){
             $ProductAmenties = [
                    'amenties' =>$amenities[$i],
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ];
                ProductAmenties::create($ProductAmenties);

            }
        return response()->json([
                'message' => 'Successfully inserted product for sale',
            ], 201);

    }


    public function second(Request $request)
    {
        $request -> validate([
            'build_name' => 'required' ,
            'type' => 'required' ,
            'willing_to_rent_out_to' => 'required' ,
            'agreement_type' => 'required' ,
            'address' => 'required' ,
            'display_address' => 'required' ,
            'city' => 'required' ,
            'locality' => 'required' ,
            'property_detail' => 'required' ,
            'nearest_landmark' => 'required' ,
            'map_latitude' => '' ,
            'map_longitude' => '' ,
            // 'product_image1' => 'required' ,
            // 'product_image2' => 'required' ,
            // 'product_image3' => 'required' ,
            // 'product_image4' => 'required' ,
            // 'product_image5' => 'required' ,
            // 'nearby_places' => 'required' ,
            'area' => 'required' ,
            'area_unit' => 'required' ,
            'carpet_area' => 'required' ,
            'bedroom' => 'required' ,
            'bathroom' => 'required' ,
            'balconies' => 'required' ,
            'additional_rooms' => 'required' ,
            'furnishing_status' => 'required' ,
            'furnishings' => '' ,
            'total_floors' => 'required' ,
            'property_on_floor' => 'required' ,
            'rera_registration_status' => 'required' ,
            'additional_parking_status' => 'required' ,
            'parking_covered_count' => '' ,
            'parking_open_count' => '' ,
            'rent_availability' => 'required' ,
            'available_for' => 'required' ,
            'buildyear' => 'required' ,
            'age_of_property' => 'required' ,
            'possession_by' => 'required' ,
            'duration_of_rent_aggreement' => 'required' ,
            'security_deposit' => 'required' ,
            'maintenance_charge' => '',
            'maintenance_charge_status' => '' ,
            'maintenance_charge_condition' => '' ,
            'ownership' => 'required' ,
            'rent_cond' => 'required' ,
            'expected_pricing' => '' ,
            'inclusive_pricing_details' => '' ,
            'tax_govt_charge' => 'required' ,
            'price_negotiable' => 'required' ,
            'deposit' => '' ,
            'brokerage_charges' => '' ,
            // 'amenities' => 'required' ,
            'facing_towards' => 'required' ,
            'availability_condition' => 'required' ,
            'expected_rent' => 'required' ,
            'inc_electricity_and_water_bill' => 'required' ,
            'month_of_notice' => 'required' ,
            'equipment' => 'required' ,
            'features' => 'required' ,
            'description' => 'required' ,
        ]);


    $imageName1=null;
    if($request->input('product_image1') != null){
        $base64_image1 = $request->input('product_image1'); // your base64 encoded
        @list($type, $file_data1) = explode(';', $base64_image1);
        @list(, $file_data1) = explode(',', $file_data1);
        $imageName1 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put('product_image_file/'.$imageName1, base64_decode($file_data1));
    }

    $imageName2=null;
    if($request->input('product_image2') != null){
        $base64_image2 = $request->input('product_image2'); // your base64 encoded
        @list($type, $file_data2) = explode(';', $base64_image2);
        @list(, $file_data2) = explode(',', $file_data2);
        $imageName2 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put('product_image_file/'.$imageName2, base64_decode($file_data2));
    }

    $imageName3=null;
    if($request->input('product_image3') != null){
        $base64_image3 = $request->input('product_image3'); // your base64 encoded
        @list($type, $file_data3) = explode(';', $base64_image3);
        @list(, $file_data3) = explode(',', $file_data3);
        $imageName3 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put('product_image_file/'.$imageName3, base64_decode($file_data3));
    }

    $imageName4=null;
    if($request->input('product_image4') != null){
        $base64_image4 = $request->input('product_image4'); // your base64 encoded
        @list($type, $file_data4) = explode(';', $base64_image4);
        @list(, $file_data4) = explode(',', $file_data4);
        $imageName4 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put('product_image_file/'.$imageName4, base64_decode($file_data4));
    }

    $imageName5=null;
    if($request->input('product_image5') != null){
        $base64_image5 = $request->input('product_image5'); // your base64 encoded
        @list($type, $file_data5) = explode(';', $base64_image5);
        @list(, $file_data5) = explode(',', $file_data5);
        $imageName5 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
        Storage::disk('public')->put('product_image_file/'.$imageName5, base64_decode($file_data5));
    }

        $user_id = Auth::user()->id;

            $product_data = new Product([
            'user_id' => $user_id ,
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
            'product_image1' => $imageName1,
            'product_image2' => $imageName2,
            'product_image3' => $imageName3,
            'product_image4' => $imageName4,
            'product_image5' => $imageName5,
            'nearby_places' => $request->nearby_places ,
            'area' => $request->area ,
            'area_unit' => $request->area_unit ,
            'carpet_area' => $request->carpet_area ,
            'bedroom' => $request->bedroom ,
            'bathroom' => $request->bathroom ,
            'balconies' => $request->balconies ,
            'additional_rooms' => $request->additional_rooms ,
            'furnishing_status' => $request->furnishing_status ,
            'furnishings' => json_encode($request->furnishings) ,
            'total_floors' => $request->total_floors ,
            'property_on_floor' => $request->property_on_floor ,
            'rera_registration_status' => $request->rera_registration_status ,
            'additional_parking_status' => $request->additional_parking_status ,
            'parking_covered_count' => $request->parking_covered_count ,
            'parking_open_count' => $request->parking_open_count ,
            'rent_availability' => $request->rent_availability ,
            'available_for' => $request->available_for ,
            'buildyear' => $request->buildyear ,
            'age_of_property' => $request->age_of_property ,
            'possession_by' => $request->possession_by ,
            'duration_of_rent_aggreement' => $request->duration_of_rent_aggreement ,
            'security_deposit' => $request->security_deposit ,
            'maintenance_charge' =>$request->maintenance_charge ,
            'maintenance_charge_status' => $request->maintenance_charge_status ,
            'maintenance_charge_condition' => $request->maintenance_charge_condition ,
            'ownership' => $request->ownership ,
            'rent_cond' => $request->rent_cond ,
            'expected_pricing' => $request->expected_pricing ,
            'inclusive_pricing_details' => $request->inclusive_pricing_details ,
            'tax_govt_charge' => $request->tax_govt_charge ,
            'price_negotiable' => $request->price_negotiable ,
            'deposit' => $request->deposit ,
            'brokerage_charges' => $request->brokerage_charges ,
            // 'amenities' => json_encode($request->amenities) ,
            'facing_towards' => $request->facing_towards ,
            'availability_condition' => $request->availability_condition ,
            'expected_rent' => $request->expected_rent ,
            'inc_electricity_and_water_bill' => $request->inc_electricity_and_water_bill ,
            'month_of_notice' => $request->month_of_notice ,
            'equipment' => $request->equipment ,
            'features' => $request->features ,
            'description' => $request->description ,
            ]);

            $user_type = Auth::user()->usertype;

            if ($user_type == 1)
                return response()->json([
                    'message' => 'Unauthorised User',
                ], 201);

            $product_data->save();
            eventtracker::create(['symbol_code' => '8', 'event' => Auth::user()->name.' created a new property listing for rent.']);
             $product_id=$product_data->id;
               $user_id = Auth::user()->id;
               $amenities=$request->amenities;
               $length=count($amenities);
               for($i=0; $i<$length;$i++){
                 $ProductAmenties = [
                        'amenties' =>$amenities[$i],
                        'user_id' => $user_id,
                        'product_id' => $product_id
                    ];
                ProductAmenties::create($ProductAmenties);

                }

            return response()->json([
                'message' => 'Successfully inserted product for rent',
                'path' => $product_data,
            ], 201);

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

        product::where('id', $request->product_id)->update(['delete_flag' => 1 ]);
          UserProductCount::where('user_id', $user_id)->where('product_id', $request->product_id)->delete();

        return response()->json([
            'message' => 'Successfully deleted Product',
        ], 201);

    }

    public function agent_properties()
    {

        $user_id = Auth::user()->id;

        $data = product::where('user_id', $user_id)->where('delete_flag', 0)->Latest()->paginate();
        //$tableq = DB::table('users')->select('id','name','email','profile_pic')->get();
        return response()->json([
            //'users'=> $tableq,
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
            'description' => 'required',
            'parking_covered_count' => 'required',
            'parking_open_count' => 'required',
            'availability_condition' => 'required',
            'buildyear' => 'required',
            'age_of_property' => 'required',
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
        $data->description = $request->description;
        $data->parking_covered_count = $request->parking_covered_count;
        $data->parking_open_count = $request->parking_open_count;
        $data->availability_condition = $request->availability_condition;
        $data->buildyear = $request->buildyear;
        $data->age_of_property = $request->age_of_property;
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
        $product = product::where('id', $request->id)->where('user_id',$user_id)->with('amenities')->first();
       
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
