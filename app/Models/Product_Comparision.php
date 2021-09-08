<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Comparision extends Model
{
    use HasFactory;
     
    protected $fillable = [
        'user_id','product_id','status',
    ];

    public function productdetails()
    {
        return $this->hasOne('App\Models\product', 'id','product_id')->with('Property_Type')->where('delete_flag', 0);
    }
    
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    public function product_img()
    {
        return $this->hasMany('App\Models\Product_img', 'product_id','product_id');
    }  
    public function amenities()
    {
        return $this->hasMany('App\Models\ProductAmenties', 'product_id','product_id');
    }
    public function Property_Type()
    {
        return $this->hasOne('App\Models\Property_type', 'id','type')->where('status', '1');
    }
}
