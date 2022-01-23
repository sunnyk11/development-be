<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderPlanFeatures extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'plan_id', 'plan_name', 'plan_type', 'plan_status', 'payment_type', 'special_tag', 'actual_price_days', 'discount_status', 'discounted_price_days', 'discount_percentage', 'plan_created_at', 'plan_updated_at','client_visit_priority','product_plans_days', 'features'];

   // protected $casts = ['features' => 'array'];
}
