<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area_district extends Model
{
    use HasFactory;

    protected $fillable = ['district_id','district','state_id','status'];

    public function locality() {
        return $this->hasMany('App\Models\area_locality', 'district_id', 'district_id');
    }

    public function state() {
        return $this->belongsTo('App\Models\area_state', 'state_id', 'state_id');
    }
}
