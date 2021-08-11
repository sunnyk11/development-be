<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\admin;
use Illuminate\Support\Facades\Storage;
use Auth;

use App\Models\User;
use App\Models\reviews;
use App\Models\savedsearches;
use App\Models\requirement;
use App\Models\product;
use App\Models\favourites;
use App\Models\last_searched_properties;
use App\Models\lawyer;
use Illuminate\Support\Facades\DB;
use App\Models\ProductAmenties;

class AdminController extends Controller
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
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function user_update(Request $request)
    {
        $usertype = Auth::user()->usertype;

        // if($usertype < 6){
        //     return response()->json([
        //         'unauthorised',
        //     ], 401);
        // }

        $request -> validate([
        'id' => 'required' ,
        'name' => '' ,
        'profile_pic' => '' ,
        'company_name' => '' ,
        'company_url' => '' ,
        'address' => '' ,
        'city' => '' ,
        'other_mobile_number' => '' ,
        'landline_number' => '' ,
        'company_profile' => '' ,
        'pan_number' => '' ,
        'aadhar_number' => '' ,
        'provided_service' => '' ,
        'place_of_practice' => '' ,
        'price_for_service' => '' ,
        'law_firm_number' => '' ,
        'practice_number' => '' ,
        'blocked' => '' ,
        'phone_number_verification_status' => '' ,
        ]);

        $data = user::find($request->id);
        $data->name = $request->name;
        $data->profile_pic = $request->profile_pic;
        $data->company_name = $request->company_name;
        $data->company_url = $request->company_url;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->other_mobile_number = $request->other_mobile_number;
        $data->landline_number = $request->landline_number;
        $data->company_profile = $request->company_profile;
        $data->pan_number = $request->pan_number;
        $data->aadhar_number = $request->aadhar_number;
        $data->provided_service = $request->provided_service;
        $data->place_of_practice = $request->place_of_practice;
        $data->price_for_service = $request->price_for_service;
        $data->law_firm_number = $request->law_firm_number;
        $data->practice_number = $request->practice_number;
        $data->blocked = $request->blocked;
        $data->phone_number_verification_status = $request->phone_number_verification_status;

        $data->save();

        $updated_data = user::find($request->id);

        return response()->json([
            'data' => $data,
            'update_data' => $updated_data

        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        //
    }

    public function user_index_admin(){

        $usertype = Auth::user()->usertype;

        if($usertype < 6){
            return response()->json([
                'unauthorised',
            ], 401);
        }

        return response()-> json([
            'data' => user::where('usertype', 1)->get(),
            'data_owner' => user::where('usertype', 2)->get(),
            'data_dealer' => user::where('usertype', 3)->get(),
            'data_lawyer' => user::where('usertype', 4)->get(),
            'data_admin' => user::where('usertype', '>', 6)->get(),
        ],200);
    }

    public function product_index_admin(){

        $usertype = Auth::user()->usertype;

        if($usertype < 6){
            return response()->json([
                'unauthorised',
            ], 401);
        }

        return response()-> json([
            'data' => product::where('delete_flag', 0)->get()
        ],200);
    }

    public function product_views(){

        $usertype = Auth::user()->usertype;

        if($usertype < 6){
            return response()->json([
                'unauthorised',
            ], 401);
        }

        return response()-> json([
        'data' => product::select('view_counter')->get()->sum('view_counter')
        ],200);
    }

    public function review_count(){

        $usertype = Auth::user()->usertype;

        if($usertype < 6){
            return response()->json([
                'unauthorised',
            ], 401);
        }

        return response()-> json([
        'data' => reviews::select('*')->get()
        ],200);
    }

    public function update_Rent_product(Request $request)
    {

        $request -> validate([
            'id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'possession_by' => 'required',
            'locality' => 'required',
            'display_address' => 'required',
            'tax_govt_charge' => 'required',
            'price_negotiable' => 'required',
            'available_for' => 'required',
            'type' => 'required',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'balconies' => 'required',
            'additional_rooms' => 'required',
            // 'furnishing_status' => 'required',
            'total_floors' => 'required',
            'property_on_floor' => 'required',
            'rera_registration_status' => 'required',
            'facing_towards' => 'required',
            'additional_parking_status' => 'required',
            'description' => 'required',
            'availability_condition' => 'required',
            'buildyear' => 'required',
            // 'age_of_property' => 'required',
            'expected_rent' => 'required',
            'inc_electricity_and_water_bill' => 'required',
            'security_deposit' => 'required',
            'duration_of_rent_aggreement' => 'required',
            // 'month_of_notice' => 'required',
            'equipment' => 'required',
            'features' => 'required',
            'area' => 'required',
            'area_unit' => 'required',
            'carpet_area' => 'required',
            'property_detail' => 'required',
            'build_name' => 'required',
            'willing_to_rent_out_to' => 'required',
            'agreement_type' => 'required',
            'nearest_landmark' => 'required',
        ]);
        $product = product::where('id', $request->id)->with('amenities')->first();

         $imageName1=$product->product_image1;     
    if($request->input('product_image1') != $product->product_image1){
        $imageName1=null;
        if($request->input('product_image1') != null){
           $base64_image1 = $request->input('product_image1'); // your base64 encoded
            @list($type, $file_data1) = explode(';', $base64_image1);
            @list(, $file_data1) = explode(',', $file_data1);
            $imageName1 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName1, base64_decode($file_data1));
        }
    }

    $imageName2=$product->product_image2;
    if($request->input('product_image2') != $product->product_image2){
        $imageName2=null;
       if($request->input('product_image2') != null){
            $base64_image2 = $request->input('product_image2'); // your base64 encoded
            @list($type, $file_data2) = explode(';', $base64_image2);
            @list(, $file_data2) = explode(',', $file_data2);
            $imageName2 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName2, base64_decode($file_data2));
        }
    }

   $imageName3=$product->product_image3;
    if($request->input('product_image3') != $product->product_image3){
       $imageName3=null;
       if($request->input('product_image3') != null){
            $base64_image3 = $request->input('product_image3'); // your base64 encoded
            @list($type, $file_data3) = explode(';', $base64_image3);
            @list(, $file_data3) = explode(',', $file_data3);
            $imageName3 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName3, base64_decode($file_data3));
        }
    }
    $imageName4=$product->product_image4;
    if($request->input('product_image4') != $product->product_image4){
        $imageName4=null;
        if($request->input('product_image4') != null){
            $base64_image4 = $request->input('product_image4'); // your base64 encoded
            @list($type, $file_data4) = explode(';', $base64_image4);
            @list(, $file_data4) = explode(',', $file_data4);
            $imageName4 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName4, base64_decode($file_data4));
        }
    }
    $imageName5=$product->product_image5;
    if($request->input('product_image5') != $product->product_image5){
         $imageName5=null;
         if($request->input('product_image5') != null){
            $base64_image5 = $request->input('product_image5'); // your base64 encoded
            @list($type, $file_data5) = explode(';', $base64_image5);
            @list(, $file_data5) = explode(',', $file_data5);
            $imageName5 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName5, base64_decode($file_data5));
        }
    }

        $data = product::find($request->id);

        $usertype = Auth::user()->usertype;

        // if($usertype <6 ){
        //     return response()->json([
        //         'unauthorised',
        //     ], 401);
        // }


        // $data->view_counter = $request->view_counter;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->rent_cond = $request->rent_cond;
        // $data->rent_availability = $request->rent_availability;
        // $data->sale_availability = $request->sale_availability;
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
        $data->product_image1 = $imageName1;
        $data->product_image2 = $imageName2;
        $data->product_image3 = $imageName3;
        $data->product_image4 = $imageName4;
        $data->product_image5 = $imageName5;
        $data->bedroom = $request->bedroom;
        $data->bathroom = $request->bathroom;
        $data->balconies = $request->balconies;
        $data->additional_rooms = $request->additional_rooms;
        $data->furnishing_status = $request->furnishing_status;
        $data->furnishings = $request->furnishings;
        $data->total_floors = $request->total_floors;
        $data->property_on_floor = $request->property_on_floor;
        $data->rera_registration_status = $request->rera_registration_status;
        // $data->amenities = $request->amenities;
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
        // $data->delete_flag = $request->delete_flag;
              $Product_Data = [
                 'address'=> $data->address,
                 'city'=>  $data->city,
                 'rent_cond' =>$data->rent_cond,
                 // 'rent_availability'=> $data->rent_availability,
                 // 'sale_availability'=>$data->sale_availability,
                 'possession_by'=> $data->possession_by,
                 'locality' =>$data->locality,
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
                 'product_image1'=>$data->product_image1,
                 'product_image2'=>$data->product_image2,
                 'product_image3'=>$data->product_image3,
                 'product_image4'=>$data->product_image4,
                 'product_image5'=>$data->product_image5,
                 'bedroom'=>$data->bedroom,
                 'bathroom'=> $data->bathroom,
                 'balconies'=> $data->balconies,
                 'additional_rooms'=> $data->additional_rooms,
                 'furnishing_status'=>$data->furnishing_status,
                 'furnishings'=>$data->furnishings,
                 'total_floors'=>$data->total_floors,
                 'property_on_floor'=>$data->property_on_floor,
                 'rera_registration_status'=>$data->rera_registration_status,
                 // 'amenities'=>$data->amenities,
                 'facing_towards'=>$data->facing_towards,
                 'description'=> $data->description ,
                 'additional_parking_status'=>$data->additional_parking_status,
                 'parking_covered_count'=>$data->parking_covered_count,
                 'parking_open_count'=>$data->parking_open_count,
                 'availability_condition'=>$data->availability_condition,
                 'buildyear'=> $data->buildyear ,
                 'age_of_property'=>$data->age_of_property,
                 'expected_rent'=>$data->expected_rent,
                 'inc_electricity_and_water_bill'=>$data->inc_electricity_and_water_bill,
                 'security_deposit'=> $data->security_deposit,
                 'duration_of_rent_aggreement'=>$data->duration_of_rent_aggreement,
                 'month_of_notice'=>$data->month_of_notice,
                 'equipment'=>$data->equipment,
                 'features'=>$data->features,
                 'nearby_places'=>$data->nearby_places,
                 'area'=>$data->area,
                 'area_unit'=>$data->area_unit,
                 'carpet_area'=>$data->carpet_area,
                 'property_detail'=>$data->property_detail,
                 'build_name'=>$data->build_name ,
                 'willing_to_rent_out_to'=>$data->willing_to_rent_out_to,
                 'agreement_type'=>$data->agreement_type,
                 'nearest_landmark'=>$data->nearest_landmark,
                 'map_latitude'=> $data->map_latitude,
                 'map_longitude'=> $data->map_longitude,
            ];  

        
        $data->save();
        $product_id=$request->id;
       $user_id = Auth::user()->id;

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

    public function update_Sales_product(Request $request)
    {

        $request -> validate([
            'id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'possession_by' => 'required',
            'locality' => 'required',
            'display_address' => 'required',
            'tax_govt_charge' => 'required',
            'price_negotiable' => 'required',
            // 'available_for' => 'required',
            'type' => 'required',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'balconies' => 'required',
            'additional_rooms' => 'required',
            // 'furnishing_status' => 'required',
            'total_floors' => 'required',
            'property_on_floor' => 'required',
            'rera_registration_status' => 'required',
            'facing_towards' => 'required',
            'additional_parking_status' => 'required',
            'description' => 'required',
            'availability_condition' => 'required',
            'buildyear' => 'required',
            // 'age_of_property' => 'required',
            'equipment' => 'required',
            'features' => 'required',
            'area' => 'required',
            'area_unit' => 'required',
            'carpet_area' => 'required',
            'property_detail' => 'required',
            'build_name' => 'required',
            'nearest_landmark' => 'required',
        ]);
        $product = product::where('id', $request->id)->with('amenities')->first();

         $imageName1=$product->product_image1;     
    if($request->input('product_image1') != $product->product_image1){
        $imageName1=null;
        if($request->input('product_image1') != null){
           $base64_image1 = $request->input('product_image1'); // your base64 encoded
            @list($type, $file_data1) = explode(';', $base64_image1);
            @list(, $file_data1) = explode(',', $file_data1);
            $imageName1 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName1, base64_decode($file_data1));
        }
    }

    $imageName2=$product->product_image2;
    if($request->input('product_image2') != $product->product_image2){
        $imageName2=null;
       if($request->input('product_image2') != null){
            $base64_image2 = $request->input('product_image2'); // your base64 encoded
            @list($type, $file_data2) = explode(';', $base64_image2);
            @list(, $file_data2) = explode(',', $file_data2);
            $imageName2 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName2, base64_decode($file_data2));
        }
    }

   $imageName3=$product->product_image3;
    if($request->input('product_image3') != $product->product_image3){
       $imageName3=null;
       if($request->input('product_image3') != null){
            $base64_image3 = $request->input('product_image3'); // your base64 encoded
            @list($type, $file_data3) = explode(';', $base64_image3);
            @list(, $file_data3) = explode(',', $file_data3);
            $imageName3 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName3, base64_decode($file_data3));
        }
    }
    $imageName4=$product->product_image4;
    if($request->input('product_image4') != $product->product_image4){
        $imageName4=null;
        if($request->input('product_image4') != null){
            $base64_image4 = $request->input('product_image4'); // your base64 encoded
            @list($type, $file_data4) = explode(';', $base64_image4);
            @list(, $file_data4) = explode(',', $file_data4);
            $imageName4 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName4, base64_decode($file_data4));
        }
    }
    $imageName5=$product->product_image5;
    if($request->input('product_image5') != $product->product_image5){
         $imageName5=null;
         if($request->input('product_image5') != null){
            $base64_image5 = $request->input('product_image5'); // your base64 encoded
            @list($type, $file_data5) = explode(';', $base64_image5);
            @list(, $file_data5) = explode(',', $file_data5);
            $imageName5 = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
            Storage::disk('public')->put($imageName5, base64_decode($file_data5));
        }
    }

        $data = product::find($request->id);

        $usertype = Auth::user()->usertype;

        // if($usertype <6 ){
        //     return response()->json([
        //         'unauthorised',
        //     ], 401);
        // }


        // $data->view_counter = $request->view_counter;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->rent_cond = $request->rent_cond;
        // $data->rent_availability = $request->rent_availability;
        // $data->sale_availability = $request->sale_availability;
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
        $data->product_image1 = $imageName1;
        $data->product_image2 = $imageName2;
        $data->product_image3 = $imageName3;
        $data->product_image4 = $imageName4;
        $data->product_image5 = $imageName5;
        $data->bedroom = $request->bedroom;
        $data->bathroom = $request->bathroom;
        $data->balconies = $request->balconies;
        $data->additional_rooms = $request->additional_rooms;
        $data->furnishing_status = $request->furnishing_status;
        $data->furnishings = $request->furnishings;
        $data->total_floors = $request->total_floors;
        $data->property_on_floor = $request->property_on_floor;
        $data->rera_registration_status = $request->rera_registration_status;
        // $data->amenities = $request->amenities;
        $data->facing_towards = $request->facing_towards;
        $data->additional_parking_status = $request->additional_parking_status;
        $data->description = $request->description;
        $data->parking_covered_count = $request->parking_covered_count;
        $data->parking_open_count = $request->parking_open_count;
        $data->availability_condition = $request->availability_condition;
        $data->buildyear = $request->buildyear;
        $data->age_of_property = $request->age_of_property;
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
        // $data->delete_flag = $request->delete_flag;
              $Product_Data = [
                 'address'=> $data->address,
                 'city'=>  $data->city,
                 'rent_cond' =>$data->rent_cond,
                 // 'rent_availability'=> $data->rent_availability,
                 // 'sale_availability'=>$data->sale_availability,
                 'possession_by'=> $data->possession_by,
                 'locality' =>$data->locality,
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
                 'brokerage_charges'=>$data->brokerage_charges,
                 'type'=> $data->type,
                 'product_image1'=>$data->product_image1,
                 'product_image2'=>$data->product_image2,
                 'product_image3'=>$data->product_image3,
                 'product_image4'=>$data->product_image4,
                 'product_image5'=>$data->product_image5,
                 'bedroom'=>$data->bedroom,
                 'bathroom'=> $data->bathroom,
                 'balconies'=> $data->balconies,
                 'additional_rooms'=> $data->additional_rooms,
                 'furnishing_status'=>$data->furnishing_status,
                 'furnishings'=>$data->furnishings,
                 'total_floors'=>$data->total_floors,
                 'property_on_floor'=>$data->property_on_floor,
                 'rera_registration_status'=>$data->rera_registration_status,
                 // 'amenities'=>$data->amenities,
                 'facing_towards'=>$data->facing_towards,
                 'description'=> $data->description ,
                 'additional_parking_status'=>$data->additional_parking_status,
                 'parking_covered_count'=>$data->parking_covered_count,
                 'parking_open_count'=>$data->parking_open_count,
                 'availability_condition'=>$data->availability_condition,
                 'buildyear'=> $data->buildyear ,
                 'age_of_property'=>$data->age_of_property,
                 'month_of_notice'=>$data->month_of_notice,
                 'equipment'=>$data->equipment,
                 'features'=>$data->features,
                 'nearby_places'=>$data->nearby_places,
                 'area'=>$data->area,
                 'area_unit'=>$data->area_unit,
                 'carpet_area'=>$data->carpet_area,
                 'property_detail'=>$data->property_detail,
                 'build_name'=>$data->build_name ,
                 'nearest_landmark'=>$data->nearest_landmark,
                 'map_latitude'=> $data->map_latitude,
                 'map_longitude'=> $data->map_longitude,
            ];  

        
        $data->save();
        $product_id=$request->id;
       $user_id = Auth::user()->id;

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

    public function admin_lawyer_service(){

        $usertype = Auth::user()->usertype;

        if($usertype < 6){
            return response()->json([
                'unauthorised',
            ], 401);
        }

        $data = lawyer::get();

        return response()->json([
            'data' => $data
        ], 201);

    }

    public function review_index()
    {
        $usertype = Auth::user()->usertype;

        if($usertype < 6){
            return response()->json([
                'unauthorised',
            ], 401);
        }


        return response()->json([
            'data' => reviews::get()
        ]);
    }

    public function user_check(Request $request)
    {
        $request -> validate([
            'id' => 'required'
        ]);

        $lawyer = User::where('id', $request->id)->first();


        return response()->json([
            'data' => $lawyer
        ]);

    }

    public function delete_product (Request $request){

        $request->validate([
            'product_id' => 'required',
        ]);


        $product_userid = product::where('id', $request->product_id)->value('user_id');

        $user_id = Auth::user()->id;

        if ($user_id < 6)
            return response()->json([
                'message' => 'Unauthorised User',
            ], 401);

        product::where('id', $request->product_id)->update(['delete_flag' => 1 ]);
        return response()->json([
            'message' => 'Successfully deleted Product',
        ], 201);

    }


}
