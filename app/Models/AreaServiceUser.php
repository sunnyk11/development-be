<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceProvider;
use App\Models\localarea;

class AreaServiceUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','user_name', 'contact', 'service_id','status'];
   

    public function service()
    {
        return $this->hasOne('App\Models\AreaService', 'service_id','service_id');
    }
    public function user_review()
    {
        return $this->hasMany('App\Models\ServiceUserReviews', 's_user_id','user_id');
    }

    public function scopeSearch($query, $searchTerm) {
        if ($searchTerm->Area) {
        	$Area = localarea::where('Area_id', $searchTerm->Area)->get();   
            $AreaId=json_decode(json_encode($Area), true);

            // dd($AreaId);
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
            
            // dd($query);
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
