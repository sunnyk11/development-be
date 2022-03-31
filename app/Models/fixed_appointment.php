<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fixed_appointment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','Source','page_name','product_id','plan_id','status'];
}
