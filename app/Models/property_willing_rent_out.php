<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_willing_rent_out extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','status'
    ];
}
