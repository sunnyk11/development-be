<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAmenties;
use App\Models\area_locality;
use App\Models\Property_type;
use App\Models\flat_type;
use Auth;
use DateTimeInterface;
use Carbon\Carbon;

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
        'crm_user_email',
        'flat_type',
        'property_notes',
        'notes_updateby'
    ];

    public function productid()
    {

        return $this->hasMany('App\Models\product', 'id');
    }
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    public function notes_updated()
    {
        return $this->hasOne('App\Models\User', 'id','notes_updateby')->select('id','email','other_mobile_number','name','last_name');
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
    public function pro_flat_Type()
    {
        return $this->hasOne('App\Models\flat_type', 'id','flat_type')->where('status', '1')->select('id','name');
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
     public function property_sub_locality()
    {
        return $this->hasone('App\Models\area_sub_locality', 'sub_locality_id','sub_locality_id')->select('sub_locality_id','sub_locality','locality_id','status');
    }

    public function property_locality()
    {
        return $this->hasone('App\Models\area_locality', 'locality_id','locality_id')->select('district_id','locality','locality_id','status');
    }

    // public function Pro_order()
    //  {
    //      return $this->hasMany('App\Models\plansRentOrders', 'property_id','id');
    //  }
	public function property_invoice() {
        return $this->hasOne('App\Models\invoices', 'property_uid','product_uid')->where(['plan_type'=> 'Let Out']);
    }
    public function product_payment_details() {
        return $this->hasOne('App\Models\admin_payment_summery','product_id','id')->orderBy('id','desc');
    }


    public function letout_invoice() {
        return $this->hasOne('App\Models\invoices', 'property_uid','product_uid')->where(['plan_status'=>'used','plan_type'=> 'Let Out'])->with('UserDetail')->where([['payment_status','!=','CANCEL'],['payment_status','!=','RETURN'],['payment_status','!=','Payment Returned']]);
    }

    public function rent_invoice() {
        return $this->hasOne('App\Models\invoices', 'property_uid','product_uid')->with('UserDetail')->where(['transaction_status'=> 'TXN_SUCCESS', 'plan_type'=> 'Rent']);
    }
    public function book_property() {
        return $this->hasOne('App\Models\invoices', 'property_uid','product_uid')->with('admin_purchase_property')->select('order_id','choose_payment_type','invoice_no','total_amount','amount_paid','property_uid')->where(['plan_type'=> 'Rent','choose_payment_type'=>'book_property','payment_status'=> 'PAID']);
    }
    public function crm_book_property() {
        return $this->hasOne('App\Models\invoices', 'property_uid','product_uid')->with('crm_purchase_property')->select('order_id','choose_payment_type','invoice_no','total_amount','amount_paid','property_uid','payment_status')->where(['plan_type'=> 'Rent','choose_payment_type'=>'book_property','payment_status'=> 'PAID']);
    }

    public function purchase_property() {
        return $this->hasOne('App\Models\invoices','property_uid','product_uid')->select('payment_status','order_id','choose_payment_type','user_id','property_uid','invoice_no','total_amount','amount_paid')->with('User_details')->where(['plan_type'=> 'Rent','choose_payment_type'=>'purchase_property','payment_status'=> 'PAID'])->orderBy('id', 'desc');
    }

    public function rented_invoice() {
        return $this->hasOne('App\Models\plansRentOrders', 'property_id','id')->with('book_property','User_details','purchase_property')->where(['transaction_status'=> 'TXN_SUCCESS', 'plan_type'=> 'Rent']);
    }		
     public function scopeSearch($query, $searchTerm) {
        if ($searchTerm->build_name) {
            $query = $query->where('build_name', 'like',  $searchTerm->build_name . "%");
        }
        if ($searchTerm->security_deposit != null) {
           $query = $query->where('security_deposit', $searchTerm->security_deposit);
        }
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
        if ($searchTerm->flat_type) {
            $flat_data = flat_type::select('id')->where('name',$searchTerm->flat_type)->first();
            $query = $query->where('flat_type',$flat_data['id']);
        }
        if ($searchTerm->type) {
            $type_id = Property_type::select('id')->where('name',$searchTerm->type)->first();
            $query = $query->where('type',$type_id['id']);
        }
        if ($searchTerm->bathrooms != null) {
            $query = $query->where('bathroom', $searchTerm->bathrooms);
        }
        if ($searchTerm->bedrooms != null) {

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

        if ($searchTerm->Furnished =='Furnished') {
            $query = $query->where('furnishing_status','1');
        }

        if ($searchTerm->Furnished =='Not Furnished') {
            $query = $query->where('furnishing_status','0');
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
            $query = $query->whereIn('sub_locality_id',$searchTerm->sub_locality);            
        }
        if ($locality) {
            $locality_id = area_locality::select('locality_id')->where('locality', $searchTerm->locality)->get();
            if(count($locality_id)>0){
              $query = $query->whereIn('locality_id',$locality_id);  
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
        if($searchTerm->admin_property_type=='letout_property'){
           $query = $query->where('order_status','0');
        }
        if($searchTerm->admin_property_type=='rentout_property'){
          $query = $query->where('order_status','1');
        }
        if($searchTerm->admin_property_type=='book_property'){
          $query = $query->where('order_status','2');
        }

        if($searchTerm->user_mobile_no){
            $user = User::select('id')->where('other_mobile_number',$searchTerm->user_mobile_no)->first();
            $query = $query->where('user_id',$user['id']);
        }
        if($searchTerm->user_email){
            $user = User::select('id')->where('email',$searchTerm->user_email)->first();
            $query = $query->where('user_id',$user['id']);
        }
        if ($searchTerm->start_date && $searchTerm->end_date) {
          $start_date_modified=$searchTerm->start_date." 00:00:00";
          $end_date_modified=$searchTerm->end_date." 23:59:59";

          $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date_modified);
          $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $end_date_modified);
          $query->whereBetween('updated_at', [$start_date,$end_date]);
        }
        return $query;  
    }	  
}
