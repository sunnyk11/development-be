<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_locality extends Model
{
    use HasFactory;

    protected $fillable = ['sub_locality_id', 'sub_locality', 'locality_id', 'status'];

    public function locality() {
        return $this->belongsTo(locality::class, 'locality_id', 'locality_id');
    }
}
