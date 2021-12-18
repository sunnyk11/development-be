<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class state_district_mapping extends Model
{
    use HasFactory;
    protected $fillable = ['state_id','user_id','district_id', 'status'];
    
    
    public function area_district()
    {
        return $this->hasone('App\Models\area_district', 'district_id','district_id');
    }
    
    public function user_locality()
    {
        return $this->hasMany('App\Models\district_locality_mapping', 'district_id','id')->with('area_locality','user_sublocality');
    }
}
