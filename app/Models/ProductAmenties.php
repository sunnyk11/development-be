<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAmenties extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'amenties',
    ];

    public function amenties()
    {
        return $this->hasOne('App\Models\Amenitie', 'id','amenties');
    }
    
}
