<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_service_mapping extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','service_id','status'];
    public function service()
    {
        return $this->hasOne('App\Models\AreaService', 'service_id','service_id');
    }
    public function user_review()
    {
        return $this->hasMany('App\Models\backend_reviews_user', 's_user_id','user_id');
    }
    public function service_user()
    {
        return $this->hasOne('App\Models\service_userlist', 'user_id','user_id');
    }
    public function user_local_area()
    {
        return $this->hasMany('App\Models\ServiceUserReviews', 'user_id','user_id');
    }

    public function scopeSearch($query, $searchTerm) {

        $sub_locality=$searchTerm->sub_locality;
        $locality=$searchTerm->locality;
        $district=$searchTerm->district;
        $city=$searchTerm->city;
        $default=1;
        $user_id=[];
        if($sub_locality){
            $locality=null;
            $district=null;
            $city=null;
            $default=null;
        } elseif ($locality) {
            $sub_locality=null;
            $district=null;
            $city=null;
            $default=null;
        } elseif ($district) {
            $sub_locality=null;
            $locality=null;
            $city=null;
            $default=null;
        } elseif ($city) {
            $locality=null;
            $district=null;
            $sub_locality=null;
            $default=null;
        }else {
            $locality=null;
            $district=null;
            $sub_locality=null;
            $city=null;
        }
        if ($sub_locality) {
            $user_id=[];
            $sub_locality= locality_sublocality_mapping::select('user_id')->where('sub_locality_id', $searchTerm->sub_locality)->get();
            $user_id=json_decode(json_encode($sub_locality), true);
        }
        if($locality) {
            $user_id=[];
            $locality= district_locality_mapping::select('user_id')->where('locality_id', $searchTerm->locality)->get();
            $user_id=json_decode(json_encode($locality), true);
        }
        if($district) {
            $user_id=[];
            $locality= state_district_mapping::select('user_id')->where('district_id', $searchTerm->district)->get();
            $user_id=json_decode(json_encode($locality), true);
        }
        if($city) {
            $user_id=[];
            $locality= user_area_mapping::select('user_id')->where('state_id', $searchTerm->city)->get();
            $user_id=json_decode(json_encode($locality), true);
        }
        if($default) {
            $user_id=[];
            $locality= user_area_mapping::select('user_id')->get();
            $user_id=json_decode(json_encode($locality), true);
        }
        if ($searchTerm->service) {
            $query = $query->where('service_id', $searchTerm->service);
        }
        $query = $query->whereIn('user_id',$user_id)->orderBy('id', 'desc');
        return $query;  
    }
    
}
