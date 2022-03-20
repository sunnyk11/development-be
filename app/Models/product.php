<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAmenties;
use App\Models\area_locality;
use App\Models\Property_type;
use Auth;
use DateTimeInterface;

class product extends Model
{
    use HasFactory; 
    protected $fillable = [
        'user_id',
        'address',
        'city',
        'rent_cond',
        'rent_availability',
        'sale_availability',
        'maintenance_charge',
        'possession_by',
        'display_address',
        'ownership',
        'expected_pricing',
        'inclusive_pricing_details',
        'tax_govt_charge',
        'price_negotiable',
        'negotiable_status',
        'maintenance_charge_status',
        'maintenance_charge',
        'maintenance_charge_condition',
        'deposit',
        'available_for',
        'brokerage_charges',
        'type',
        'bedroom',
        'bathroom',
        'balconies',
        'furnishing_status',
        'furnishings',
        'total_floors',
        'property_on_floor',
        'rera_registration_status',
        'facing_towards',
        'description',
        'additional_parking_status',
        'parking_covered_count',
        'parking_open_count',
        'availability_condition',
        'buildyear',
        'age_of_property',
        'expected_rent',
        'inc_electricity_and_water_bill',
        'security_deposit',
        'duration_of_rent_aggreement',
        'month_of_notice',
        'equipment',
        'features',
        'nearby_places',
        'area',
        'area_unit',
        'carpet_area',
        'property_detail',
        'build_name',
        'additional_rooms_status',
        'willing_to_rent_out_to',
        'agreement_type',
        'map_latitude',
        'map_longitude',
        'video_link',
        'draft',
        'product_uid',
        'order_status',
        'address_details',
        'state_id',
        'district_id',
        'locality_id',
        'sub_locality_id',
        'enabled',
        'property_mode',
        'crm_user_email'
    ];

    public function productid()
    {

        return $this->hasMany('App\Models\product', 'id');
    }
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    public function pro_user_details()
    {
        return $this->hasOne('App\Models\User', 'id','user_id')->select('id','name');
    }
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function product_comparision()
    {

        $user_id = Auth::user()->id;
        return $this->hasOne('App\Models\Product_Comparision','product_id','id')->where('status', '1')->where('user_id', $user_id)->orderBy('id', 'asc');
    }
    public function listing_pro_comp()
    {

        $user_id = Auth::user()->id;
        return $this->hasOne('App\Models\Product_Comparision', 'product_id','product_id')->where('status', '1')->where('user_id', $user_id)->orderBy('id', 'asc');
    }

    public function Single_wishlist()
    {
        
        $user_id = Auth::user()->id;
        return $this->hasOne('App\Models\Wishlist', 'product_id','id')->where('user_id', $user_id)->where('status', '1');
    }

    public function listing_wishlist()
    {
        $user_id = Auth::user()->id;
        return $this->hasOne('App\Models\Wishlist', 'product_id','product_id')->where('user_id', $user_id)->where('status', '1');
    }
    
    public function product_wishlist_crm()
    {
        return $this->hasOne('App\Models\Wishlist', 'product_id','id')->where('status', '1');
    }
    public function product_comp()
    {
        return $this->hasOne('App\Models\Product_Comparision', 'product_id','user_id')->where('status', '1')->orderBy('id', 'asc');
    }
    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist', 'product_id','id');
    }
    public function locality()
    {
        return $this->hasOne('App\Models\area', 'id','locality');
    }
    public function amenities()
    {
        return $this->hasMany('App\Models\ProductAmenties', 'product_id','id')->with('amenties');
    }

    public function product_img()
    {
        return $this->hasMany('App\Models\Product_img', 'product_id','id')->select('id','product_id','image');
    }

    public function product_img_listing()
    {
        return $this->hasMany('App\Models\Product_img', 'product_id','product_id')->select('id','product_id','image');
    }
    public function Property_Type()
    {
        return $this->hasOne('App\Models\Property_type', 'id','type')->where('status', '1')->select('id','name');
    }
    public function Property_area_unit()
    {
        return $this->hasOne('App\Models\area_unit', 'id','area_unit')->where('status', '1')->select('id','unit');
    }
    public function property_room()
    {
        return $this->hasMany('App\Models\property_room_pivot', 'product_id','id')->where('status', '1')->with('room')->select('id','room_id','product_id');
    }
    public function willing_rent_out()
    {
        return $this->hasOne('App\Models\property_willing_rent_out', 'id','willing_to_rent_out_to')->where('status', '1')->select('id','name');
    }
    public function maintenance_condition()
    {
        return $this->hasOne('App\Models\property_maintenance_condition', 'id','maintenance_charge_condition')->where('status', '1')->select('id','name');
    }
    public function aggeement_type()
    {
        return $this->hasOne('App\Models\property_ageement_type', 'id','agreement_type')->where('status', '1')->select('id','name');
    }
    public function ageement_duration()
    {
        return $this->hasOne('App\Models\property_ageement_duration', 'id','duration_of_rent_aggreement')->where('status', '1')->select('id','name');
    }

    // public function Pro_order()
    // {
    //     return $this->hasOne('App\Models\product_order', 'product_id','product_uid')->where('transaction_status', 'TXN_SUCCESS');
    // }

    public function product_order()
    {
        return $this->hasOne('App\Models\product_order', 'id','product_id')->where(['status'=> '1']);
    }
 
     public function product_state()
    {
        return $this->hasone('App\Models\area_state', 'state_id','state_id')->select('state_id','state','status');
    }
     public function product_district()
    {
        return $this->hasone('App\Models\area_district', 'district_id','district_id');
    }
    public function product_locality()
    {
        return $this->hasone('App\Models\area_locality', 'locality_id','locality_id');
    }
    public function product_sub_locality()
    {
        return $this->hasone('App\Models\area_sub_locality', 'sub_locality_id','sub_locality_id');
    }

    // public function Pro_order()
    //  {
    //      return $this->hasMany('App\Models\plansRentOrders', 'property_id','id');
    //  }
	public function property_invoice() {
        return $this->hasOne('App\Models\invoices', 'property_uid','product_uid')->where(['plan_type'=> 'Let Out']);
    }


    public function letout_invoice() {
        return $this->hasOne('App\Models\invoices', 'property_uid','product_uid')->where(['plan_status'=>'used','plan_type'=> 'Let Out'])->where([['payment_status','!=','CANCEL'],['payment_status','!=','RETURN']]);
    }
    public function rent_invoice() {
        return $this->hasOne('App\Models\invoices', 'property_uid','product_uid')->where(['transaction_status'=> 'TXN_SUCCESS', 'plan_type'=> 'Rent']);
    }		
     public function scopeSearch($query, $searchTerm) {
        if ($searchTerm->build_name) {
            $query = $query->where('build_name', 'like',  $searchTerm->build_name . "%");
        }
        // if ($searchTerm->location) {
        //    $query = $query->where('address', 'like', "%" . $searchTerm->location . "%");
        // }
        if ($searchTerm->product_id) {
            $product_id=substr($searchTerm->product_id,8);
            $id= (int)($product_id);
           $query = $query->where('products.id',$id);
        }
        if ($searchTerm->city) {
           $query = $query->where('state_id','1');
        }
        if ($searchTerm->area_unit) {
            $area_unit = area_unit::select('id')->where('unit',$searchTerm->area_unit)->first();
            $query = $query->where('area_unit',$area_unit['id']);
        }
        if ($searchTerm->type) {
            $type_id = Property_type::select('id')->where('name',$searchTerm->type)->first();
            $query = $query->where('type',$type_id['id']);
        }
        if ($searchTerm->bathrooms) {
            $query = $query->where('bathroom', $searchTerm->bathrooms);
        }
        if ($searchTerm->bedrooms) {

            $query = $query->where('bedroom', $searchTerm->bedrooms);
        }
         if ($searchTerm->min_price) {
            $min =$searchTerm->min_price;
            $query->where(function($query) use ($min){
                $query->where('products.expected_rent', '>=', $min);
            });
        }
        if ($searchTerm->max_price) {
            $max =$searchTerm->max_price;
            $query->where(function($query) use ($max){
                $query->where('products.expected_rent', '<=', $max);
            });
        }

        if ($searchTerm->years) {
            $query = $query->where('products.buildyear', $searchTerm->years);
        }
        if ($searchTerm->property_status == "all") {
            $query = $query->orderBy('products.id', 'asc');
        }
        if ($searchTerm->property_status== "recently") {
            $query = $query->orderBy('products.id', 'desc');
        }
        if ($searchTerm->property_status == "viewed") {
            $query = $query->orderBy('view_counter', 'desc');
        }
        $sub_locality=$searchTerm->sub_locality;
        $locality=$searchTerm->locality;
          if($sub_locality){
            $locality=null;
            $default=null;
        } elseif ($locality) {
            $sub_locality=null;
            $default=null;
        }else{
            $locality=null;
            $sub_locality=null;
        } 
        if($sub_locality){
            $query = $query->where('sub_locality_id',$searchTerm->sub_locality);            
        }
        if ($locality) {
            $locality = area_locality::select('locality_id')->where('locality', $searchTerm->locality)->get();
            if(count($locality)>0){
              $query = $query->whereIn('locality_id',$locality);  
            }else{
                $sub_locality = area_sub_locality::select('locality_id')->where('sub_locality', $searchTerm->locality)->get();
                // $locality_update = area_locality::select('locality_id')->where('locality_id', $sub_locality)->get();
                 $query = $query->whereIn('locality_id',$sub_locality);
            }
        }
        if ($searchTerm->amenities) {
            $amenities_data = ProductAmenties::select('product_id')->whereIn('amenties',$searchTerm->amenities)->get();
             $amenitiesID=json_decode(json_encode($amenities_data), true);
             $length=count($amenitiesID);
              $array=[]; 
            for($i=0; $i<$length; $i++){
                array_push($array,$amenitiesID[$i]['product_id']);
            }
            $query = $query->whereIn('products.id',$array);            
        }
        return $query;  
    }	  
}
