<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','user_email','product_id','orderId','transaction_status','status','plans_type',
    ];

    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'email','user_email');
    }
    public function Pro_order()
    {
        return $this->hasOne('App\Models\product', 'product_uid','product_id')->where(['delete_flag'=> '0','draft'=> '0'])->with('product_img');
    }
}
