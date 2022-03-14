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
                           'plan_apply_date',
                           'property_amount'
                        ];
                        
    public function productDetails()
    {
        return $this->hasOne('App\Models\product', 'product_uid','property_uid')->select('id','product_uid','build_name','enabled','order_status');
    }
    public function propertyDetails()
    {
        return $this->hasOne('App\Models\product', 'product_uid','property_uid');
    }
    
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    
    public function property_status()
    {
        return $this->hasOne('App\Models\plansRentOrders', 'invoice_no','invoice_no');
    }
}
