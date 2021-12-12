<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class locality extends Model
{
    use HasFactory;

    protected $fillable = ['locality_id','locality','district_id','status'];

    public function sub_locality() {
        return $this->hasMany(sub_locality::class, 'locality_id', 'locality_id');
    }

    public function district() {
        return $this->belongsTo(district::class, 'district_id' , 'district_id');
    }
}
