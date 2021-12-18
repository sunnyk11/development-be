<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class locality_sublocality_mapping extends Model
{
    use HasFactory;
    protected $fillable = [ 'locality_id','user_id','sub_locality_id', 'status'];
    
    public function area_sub_locality()
    {
        return $this->hasone('App\Models\area_sub_locality', 'sub_locality_id','sub_locality_id');
    }
}
