<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceData extends Model
{
    use HasFactory;

    protected $fillable = ['gstin', 'pan_no', 'mobile_no', 'email', 'website_address', 'address', 'cin', 'sac', 'sgst', 'cgst'];
}
