<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetOutFeatures extends Model
{
    use HasFactory;

    protected $fillable = ['feature_id', 'feature_name', 'plan_id', 'feature_details'];
}
