<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area_sub_locality extends Model
{
    use HasFactory;

    protected $fillable = ['sub_locality_id', 'sub_locality', 'locality_id', 'status'];

    public function locality() {
        return $this->belongsTo('App\Models\area_locality', 'locality_id', 'locality_id')->with('district');
    }
}
