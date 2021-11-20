<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProductCount extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id','product_id','Product_count',
    ];
     public function productdetails()
    {
        return $this->hasOne('App\Models\product','id','product_id')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0', 'enabled' => 'yes']);
    }
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    public function product_img()
    {
        return $this->hasMany('App\Models\Product_img', 'product_id','product_id');
    }
}
