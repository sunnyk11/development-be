<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_grouping_pivot extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'area_group'];

    public function area_group_permission() {
        return $this->hasone('App\Models\area_group','id', 'area_group')->with('pivot_data');
    }
}
