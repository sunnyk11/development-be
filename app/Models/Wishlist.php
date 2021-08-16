<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','product_id','status',
    ];

    
    public function productdetails()
    {
        return $this->hasOne('App\Models\product', 'id','product_id')->with('Property_Type');
    }
    
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
     public function product_img()
    {
        return $this->hasMany('App\Models\Product_img', 'product_id','product_id');
    } 
    
    public function product_comparision()
    {
        return $this->hasOne('App\Models\Product_Comparision', 'product_id','product_id')->where('status', '1')->orderBy('id', 'asc')->take(4);
    } 
}
