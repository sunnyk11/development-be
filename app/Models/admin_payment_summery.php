<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTimeInterface;

class admin_payment_summery extends Model
{
    use HasFactory;
     protected $fillable = ['product_id','payment_image','amount','created_user','property_owner','payment_status','transaction_id','message','bank_details_json','payment_type','status'];

    public function pro_owner()
    {
        return $this->hasOne('App\Models\User', 'id','property_owner');
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
     public function pro_created_user()
    {
        return $this->hasOne('App\Models\User', 'id','created_user');
    }
     public function productdetails()
    {
        return $this->hasOne('App\Models\product','id', 'product_id')->with('letout_invoice')->select('id','build_name','order_status','expected_rent','product_uid');
    }

     public function scopeSearch($query, $searchTerm) {
        if($searchTerm->admin_payment_type){
          $query = $query->where('payment_status',$searchTerm->admin_payment_type);
        }
        if ($searchTerm->start_date && $searchTerm->end_date) {
          $start_date_modified=$searchTerm->start_date." 00:00:00";
          $end_date_modified=$searchTerm->end_date." 23:59:59";

          $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date_modified);
          $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $end_date_modified);
          $query->whereBetween('created_at', [$start_date,$end_date]);
        }
        return $query;  
    }	
}
