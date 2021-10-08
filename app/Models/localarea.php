<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class localarea extends Model
{
    use HasFactory;

    protected $fillable = ['loc_area_id','local_area', 'Area_id', 'status'];
}
