<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class district extends Model
{
    use HasFactory;

    protected $fillable = ['district_id','district','state_id','status'];

    public function locality() {
        return $this->hasMany(locality::class, 'district_id', 'district_id');
    }

    public function state() {
        return $this->belongsTo(state::class, 'state_id', 'state_id');
    }
}
