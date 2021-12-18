<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area_locality extends Model
{
    use HasFactory;

    protected $fillable = ['locality_id','locality','district_id','status'];

    public function sub_locality() {
        return $this->hasMany('App\Models\area_sub_locality',  'locality_id', 'locality_id');
    }

    public function district() {
        return $this->belongsTo('App\Models\area_district',  'district_id' , 'district_id');
    }
}
