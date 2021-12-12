<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_service_provider extends Model
{
    use HasFactory;
    protected $fillable = ['loc_area_id', 'user_id', 'status'];
    
    public function area_user()
    {
        return $this->hasone('App\Models\localarea', 'loc_area_id','loc_area_id');
    }
}
