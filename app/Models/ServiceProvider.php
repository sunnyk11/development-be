<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ServiceProvider extends Model
{
    use HasFactory;
    protected $table = "service_provider";
    protected $fillable = ['loc_area_id', 'user_id', 'status'];
}
