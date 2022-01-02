<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyPlans extends Model
{
    use HasFactory;

    protected $fillable = ['plan_name', 'plan_type', 'payment_type', 'actual_price_days', 'discount', 'discounted_price_days', 'discount_percentage', 'special_tag', 'plan_status'];

    public function features() {
        return $this->belongsToMany(plansFeatures::class, 'plans_features_pivots', 'plan_id', 'feature_id')->with('more_info');
    }
}
