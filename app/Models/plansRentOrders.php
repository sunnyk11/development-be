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
        'choose_payment_type',
        'payment_percentage',
        'property_uid',
        'agreement_price'
    ];

    public  function product_details(){
        return $this->hasOne('App\Models\product','id', 'property_id')->with('Property_area_unit', 'maintenance_condition');
    }

    public function book_invoice()
    {
        return $this->hasOne('App\Models\invoices', 'order_id','order_id')->select('id','invoice_no','choose_payment_type','payment_percentage','order_id','payment_status')->where('choose_payment_type','book_property');
    }
}
