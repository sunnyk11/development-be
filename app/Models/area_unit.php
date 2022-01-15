<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area_unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'unit','status'
    ];
}
