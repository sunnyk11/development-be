<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class moreInfo extends Model
{
    use HasFactory;

    protected $fillable = ['more_info'];

    public function feature() {
        return $this->belongsTo(plansFeatures::class, 'more_info_id', 'id'); 
    }
}
