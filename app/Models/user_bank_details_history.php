<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_bank_details_history extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','mobile_no','account_holder', 'bank_acount_no', 'ifsc_code','account_paytm_verify_id','status'];
}
