<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_logs extends Model
{
    use HasFactory;
    protected $fillable = ['system_ip', 'device_info', 'browser_info', 'url', 'product_id', 'type','user_mobile','user_email', 'input_info','user_cart'];
}
