<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class area_group_pivot extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_id','sub_locality_id','status'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
     public function sub_locality() {
        return $this->hasone('App\Models\area_sub_locality',  'sub_locality_id', 'sub_locality_id')->where('status','1')->select('sub_locality_id','sub_locality','status');
    }

}
