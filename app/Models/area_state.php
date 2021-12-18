<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area_state extends Model
{
    use HasFactory;

    protected $fillable = ['state_id', 'state', 'status'];

    public function districts() {
        return $this->hasMany('App\Models\area_district', 'state_id', 'state_id');
    }
}
