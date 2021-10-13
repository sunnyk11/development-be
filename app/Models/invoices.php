<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no', 
                           'plan_name', 
                           'plan_id', 
                           'plan_type', 
                           'payment_type', 
                           'order_id', 
                           'expected_rent', 
                           'plan_price', 
                           'payment_status',
                           'amount_paid',
                           'transaction_status',
                           'user_email',
                           'user_id',
                           'invoice_generated_date',
                           'invoice_paid_date',
                           'payment_mode',
                           'payment_received',
                           'plan_status',
                           'property_uid',
                           'property_amount'
                        ];
}
