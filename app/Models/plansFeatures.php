<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plansFeatures extends Model
{
    use HasFactory;

    protected $fillable = ['feature_name', 'feature_details', 'feature_value', 'feature_value_text', 'more_info_status', 'more_info_id', 'status'];

    public function plans() {
        return $this->belongsToMany(PropertyPlans::class);
    }

    public function more_info() {
        return $this->hasOne(moreInfo::class, 'id', 'more_info_id'); 
    }
 }
