<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service_userlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','user_name', 'contact','status'];

    public function service()
    {
        return $this->hasOne('App\Models\User_service_mapping', 'user_id','user_id')->with('service');
    }
    
    public function user_review()
    {
        return $this->hasMany('App\Models\backend_reviews_user', 's_user_id','user_id');
    }
    public function user_service()
    {
        return $this->hasMany('App\Models\User_service_mapping', 'user_id','user_id')->with('service');
    }
    public function user_state()
    {
        return $this->hasMany('App\Models\user_area_mapping', 'user_id','user_id');
    }
    public function user_district()
    {
        return $this->hasMany('App\Models\state_district_mapping', 'user_id','user_id');
    }
    public function user_locality()
    {
        return $this->hasMany('App\Models\district_locality_mapping', 'user_id','user_id')->with('area_locality');
    }
    public function user_sublocality()
    {
        return $this->hasMany('App\Models\locality_sublocality_mapping', 'user_id','user_id')->with('area_sub_locality');
    }
    public function user_local_area()
    {
        return $this->hasMany('App\Models\backend_reviews_user', 'user_id','user_id');
    }
    public function local_area_user()
    {
        return $this->hasone('App\Models\user_service_provider', 'user_id','user_id')->with('area_user');
    }
    public function user_area()
    {
        return $this->hasone('App\Models\user_area_mapping', 'user_id','user_id')->with('area_state','user_district');
    }

    public function scopeSearch($query, $searchTerm) {
        if ($searchTerm->Area) {
        	$Area = localarea::where('Area_id', $searchTerm->Area)->get();   
            $AreaId=json_decode(json_encode($Area), true);

             $length=count($AreaId);
            $area_id=[];
            for($i=0; $i<$length; $i++){
                array_push($area_id,$AreaId[$i]['loc_area_id']);
            }
            $LocalArea = ServiceProvider::whereIn('loc_area_id', $area_id)->get();
            $LocalAreaId=json_decode(json_encode($LocalArea), true);
            $LocalArea_length=count($LocalAreaId);
              $array=[]; 
            for($i=0; $i<$LocalArea_length; $i++){
                array_push($array,$LocalAreaId[$i]['user_id']);
            }
            $query = $query->whereIn('user_id',$array)->orderBy('id', 'desc');
        }

        if ($searchTerm->LocalArea) {
            $LocalArea = ServiceProvider::where('loc_area_id', $searchTerm->LocalArea)->get();
            $LocalAreaId=json_decode(json_encode($LocalArea), true);
             $length=count($LocalAreaId);
              $array=[]; 
            for($i=0; $i<$length; $i++){
                array_push($array,$LocalAreaId[$i]['user_id']);
            }
            $query = $query->whereIn('user_id',$array)->orderBy('id', 'desc');
        }

        if ($searchTerm->service) {
            $query = $query->where('service_id', $searchTerm->service);
        }
        return $query;  
    }
}
