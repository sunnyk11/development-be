<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lawyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'service_name',
        'service_details',
        'price'
    ];
}
