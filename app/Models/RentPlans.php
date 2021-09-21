<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentPlans extends Model
{
    use HasFactory;

    protected $fillable = ['plan_name', 'plan_ID', 'payment_type', 'plan_price', 'status'];
}
