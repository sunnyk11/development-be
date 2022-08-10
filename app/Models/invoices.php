<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Carbon\Carbon;

class invoices extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no', 
                           'plan_name', 
                           'plan_id', 
                           'plan_type', 
                           'payment_type', 
                           'order_id', 
                           'expected_rent', 
                           'plan_price', 
                           'payment_status',
                           'amount_paid',
                           'transaction_status',
                           'user_email',
                           'user_id',
                           'invoice_generated_date',
                           'invoice_paid_date',
                           'payment_mode',
                           'payment_received',
                           'plan_status',
                           'property_uid',
                           'plan_apply_date',
                           'property_amount'
                        ];
                        
    public function productDetails()
    {
        return $this->hasOne('App\Models\product', 'product_uid','property_uid')->select('id','product_uid','build_name','enabled','order_status');
    }
    public function propertyDetails()
    {
        return $this->hasOne('App\Models\product', 'product_uid','property_uid')->with('product_img','product_state','product_district','product_locality','product_sub_locality','letout_invoice','rent_invoice');
    }

    public function property_rent_table()
    {
        return $this->hasOne('App\Models\plansRentOrders', 'invoice_no','invoice_no');
    }
    
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }

    public function plan_features() {
         return $this->hasOne('App\Models\PropertyPlans','id','plan_id')->with('features');
    }
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public  function order_details(){

        return $this->hasOne('App\Models\plansRentOrders', 'order_id','order_id')->with('product_details');
    }
    
    public function property_status()
    {
        return $this->hasOne('App\Models\plansRentOrders', 'invoice_no','invoice_no');
    }
    public function scopeSearch($query, $searchTerm) {

        if ($searchTerm->start_date && $searchTerm->end_date) {
          $start_date_modified=$searchTerm->start_date." 00:00:00";
           $end_date_modified=$searchTerm->end_date." 23:59:59";

            $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date_modified);
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $end_date_modified);
                $query->whereBetween('created_at', [$start_date,$end_date]);
        }
        if($searchTerm->invoice_type){
          $query = $query->where('invoices.payment_status',$searchTerm->invoice_type);
        }
        if($searchTerm->plan_type){
          $query = $query->where('plan_type',$searchTerm->plan_type);
          
        }
        if($searchTerm->delivery_status){
          if($searchTerm->delivery_status == 'Service Delivered'){
            $query = $query->where('service_delivered_status',$searchTerm->delivery_status);
          
          }else{
            $data=null;
          $query = $query->where('service_delivered_status',$data);
          
          }
        }
    }
}
