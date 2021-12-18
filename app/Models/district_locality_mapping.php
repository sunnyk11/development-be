<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class district_locality_mapping extends Model
{
    use HasFactory;
    protected $fillable = ['district_id','user_id','locality_id', 'status'];
    
    public function area_locality()
    {
        return $this->hasone('App\Models\area_locality', 'locality_id','locality_id');
    }
    
    public function user_sublocality()
    {
        return $this->hasMany('App\Models\locality_sublocality_mapping', 'locality_id','id')->with('area_sub_locality');
    }
}
