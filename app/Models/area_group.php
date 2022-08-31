<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class area_group extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_name','created_user','status'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function pivot_data()
    {
        return $this->hasMany('App\Models\area_group_pivot', 'group_id','id')->with('sub_locality');
    }
}
