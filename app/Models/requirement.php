<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'rental_sale_condition',
        'purchase_mode',
        'cash_amount',
        'loan_amount',
        'property_type',
        'requirement',
    ];
}
