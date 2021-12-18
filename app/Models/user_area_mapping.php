<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_area_mapping extends Model
{
    use HasFactory;
    protected $fillable = ['state_id', 'user_id', 'status'];
    
    public function area_state()
    {
        return $this->hasone('App\Models\area_state', 'state_id','state_id');
    }
    
    public function user_district()
    {
        return $this->hasMany('App\Models\state_district_mapping', 'state_id','id')->with('area_district','user_locality');
    }
}
