<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plansOrders extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_email', 'order_id', 'plan_type', 'plan_name', 'plan_id', 'expected_rent', 'plan_price', 'amount_paid', 'transaction_status','invoice_no', 'payment_type'];

    public function plan_status_invoice()
    {
        return $this->hasOne('App\Models\invoices', 'invoice_no','invoice_no')->select('invoice_no','plan_status');
    }
}
