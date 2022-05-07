<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_visit_feedback extends Model
{
    use HasFactory;
     protected $fillable = [
        'star_rating','system_ip','device_info','message','status',
    ];
}
