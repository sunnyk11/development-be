<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Wishlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','product_id','status',
    ];

    
    public function productdetails()
    {
        //return $this->hasOne('App\Models\product', 'id','product_id')->with('Property_Type')->where('delete_flag', 0);
        return $this->hasOne('App\Models\product', 'id','product_id')->with('Property_Type','product_comparision','UserDetail','product_img','product_state','product_locality')->where(['delete_flag'=> '0','draft'=> '0','order_status'=> '0']);
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
        $user_id = Auth::user()->id;
        return $this->hasOne('App\Models\Product_Comparision', 'product_id','product_id')->where('status', '1')->where('user_id', $user_id);
    } 
}
