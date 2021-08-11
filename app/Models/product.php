<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAmenties;

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
        'locality',
        'display_address',
        'ownership',
        'expected_pricing',
        'inclusive_pricing_details',
        'tax_govt_charge',
        'price_negotiable',
        'maintenance_charge_status',
        'maintenance_charge',
        'maintenance_charge_condition',
        'deposit',
        'available_for',
        'brokerage_charges',
        'type',
        'product_image1',
        'product_image2',
        'product_image3',
        'product_image4',
        'product_image5',
        'bedroom',
        'bathroom',
        'balconies',
        'additional_rooms',
        'furnishing_status',
        'furnishings',
        'total_floors',
        'property_on_floor',
        'rera_registration_status',
        'amenities',
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
        'willing_to_rent_out_to',
        'agreement_type',
        'nearest_landmark',
        'map_latitude',
        'map_longitude',
    ];

    public function productid()
    {

        return $this->hasMany('App\Models\product', 'id');
    }
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist', 'product_id','id');
    }
    public function amenities()
    {
        return $this->hasMany('App\Models\ProductAmenties', 'product_id','id');
    }

    public function roles()
    {

    }

    public function scopeSearch($query, $searchTerm) {
        if ($searchTerm->build_name) {
            $query = $query->where('build_name', 'like', "%" . $searchTerm->build_name . "%");
        }
        if ($searchTerm->Location) {
           $query = $query->where('city', 'like', "%" . $searchTerm->Location . "%");
        }
        if ($searchTerm->area_unit) {
            $query = $query->where('area_unit', $searchTerm->area_unit);
        }
        if ($searchTerm->type) {
            $query = $query->where('type', $searchTerm->type);
        }
        if ($searchTerm->Bathrooms) {
            $query = $query->where('bathroom', $searchTerm->Bathrooms);
        }
        if ($searchTerm->Bedrooms) {
            $query = $query->where('bedroom', $searchTerm->Bedrooms);
        }
        if ($searchTerm->availability_condition) {
            $query = $query->where('availability_condition', $searchTerm->availability_condition);
        }
        if ($searchTerm->Years) {
            $query = $query->where('buildyear', $searchTerm->Years);
        }
        if ($searchTerm->Minimum && $searchTerm->Maximum) {
            $min=(int)$searchTerm->Minimum;
            $max=(int)$searchTerm->Maximum;            
            $query =$query->where('expected_pricing', '>=',$min)->where('expected_pricing', '<=', $max)->orWhere('expected_rent', '>=',$min)->orWhere('expected_rent', '>=',$max);
        }
        if ($searchTerm->property_status== "all") {
            $query = $query->orderBy('id', 'desc');
        }
        if ($searchTerm->property_status== "Recently") {
            $query = $query->orderBy('id', 'desc')->take(8);
        }
        if ($searchTerm->property_status== "Viewed") {
            $query = $query->where('view_counter', '>=',1)->orderBy('view_counter', 'desc');
        } 
        if ($searchTerm->amenities) {
            $amenities_data = ProductAmenties::select('product_id')->whereIn('amenties',$searchTerm->amenities)->get();
             $amenitiesID=json_decode(json_encode($amenities_data), true);
             $length=count($amenitiesID);
              $array=[]; 
            for($i=0; $i<$length; $i++){
                array_push($array,$amenitiesID[$i]['product_id']);
            }
            $query = $query->whereIn('id',$array)->orderBy('id', 'desc');            
        }
        return $query;  
    }

}
