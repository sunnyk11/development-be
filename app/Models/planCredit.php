<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class planCredit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_email', 'credits', 'payment_status', 'invoice_no'];
}
