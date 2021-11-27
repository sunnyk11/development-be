<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;

class Property_type extends Model
{ 
    use HasFactory;
    protected $fillable = [
        'name','status'
    ];
    public function Product_type_count()
    {
        return $this->hasMany('App\Models\product', 'type','name')->select('type')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes']);
    }
}
