<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plansRentOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_email',
        'order_id',
        'plan_type',
        'plan_name',
        'plan_id',
        'payment_type',
        'expected_rent',
        'plan_price',
        'gst_amount',
        'maintenance_charge',
        'security_deposit',
        'total_amount',
        'payment_status',
        'amount_paid',
        'payment_mode',
        'transaction_status',
        'invoice_no',
        'property_name',
        'property_id',
        'property_uid',
        
    ];
}
