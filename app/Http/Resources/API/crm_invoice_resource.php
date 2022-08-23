<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;

class crm_invoice_resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $company_details = DB::table('invoice_data')->first();
        $expected_rent=($this->property_data == null ? 0 : $this->property_data->expected_rent);
        // return $this->property_data;
          $security_deposit =
             ($this->property_data == null ? 0 : $this->property_data->security_deposit);
          $maintenance_charge= ($this->property_data == null ? 0 :($this->property_data->maintenance_charge_status == 0 ? 0 :$this->property_data->maintenance_charge));

          $cgst=round((($company_details->cgst * ($this->crm_plan_features->crm_features[0]->feature_value+$this->plan_price)) / 100));
          $sgst=round((($company_details->sgst * ($this->crm_plan_features->crm_features[0]->feature_value+$this->plan_price)) / 100));
          $rent_aggrement_price = $this->crm_plan_features->crm_features[0]->feature_value;
          $plan_aggrement_price=round(($rent_aggrement_price+$this->plan_price));
        if($this->plan_type=='Let Out'){

         return [
            'invoice_id' => $this->id,
            'invoice_no' => $this->invoice_no,
            'order_id' => $this->order_id,
            'plan_name' => $this->plan_name,
            'plan_id' => $this->plan_id,
            'plan_type' => $this->plan_type,
            'payment_type' => $this->payment_type,

            'property_price' =>$expected_rent,

            'plan_price' => $this->plan_price,
            'payment_status' =>($this->payment_status == null ? 'NO' : $this->payment_status),
            'payment_status_change_reason' => $this->payment_status_change_reason,
            'payment_received' => $this->payment_received,
            'amount_paid' => $this->amount_paid,
            'transaction_status' => $this->transaction_status,
            'user_email' => $this->user_email,
            'user_id' => $this->user_id,
            'service_delivered_status' => $this->service_delivered_status,
            'service_delivered_date' => $this->service_delivered_date,
            'invoice_generated_date' => $this->invoice_generated_date,
            'invoice_paid_date' => $this->invoice_paid_date,
            'plan_apply_date' => $this->plan_apply_date,
            'user_first_name' => $this->user_details->name,
            'user_last_name' => $this->user_details->last_name,
            'usertype' => $this->user_details->usertype,
            'property_security_deposit' =>$security_deposit,
            'property_status'=>($this->property_status == null ? 'NO' :$this->property_status),
             'property_payment_status' =>($this->property_data == null ? 'NO' : $this->property_data->payment_status),
            'property_maintenance_charge' =>$maintenance_charge,
            'maintenance_charge_condition' =>($this->property_data == null ? null :($this->property_data->maintenance_charge_status=='0' ? 'No':$this->property_data->maintenance_condition->name)),
            'property_name' =>($this->property_data == null ? 'NO' : $this->property_data->build_name),
            'rent_aggrement_price' =>$rent_aggrement_price,
            'plan_aggrement_price' =>$plan_aggrement_price,
            'sgst_amount'=>$sgst,
           'cgst_amount'=>$cgst,
           'total_amount_owner(A)'=>$plan_aggrement_price,
            // 'Taxable_amount(B)' =>$plan_aggrement_price,
           'total_tax(B)'=>$sgst+$cgst,
           'total_amount'=>$plan_aggrement_price+$cgst+$sgst,
        ];
        }else{

         return [
            'invoice_id' => $this->id,
            'invoice_no' => $this->invoice_no,
            'order_id' => $this->order_id,
            'plan_name' => $this->plan_name,
            'plan_id' => $this->plan_id,
            'plan_type' => $this->plan_type,
            'payment_type' => $this->payment_type,

            'property_price' =>$expected_rent,

            'plan_price' => $this->plan_price,
            'payment_status' =>($this->payment_status == null ? 'NO' : $this->payment_status),
            'payment_status_change_reason' => $this->payment_status_change_reason,
            'payment_received' => $this->payment_received,
            'amount_paid' => $this->amount_paid,
            'transaction_status' => $this->transaction_status,
            'user_email' => $this->user_email,
            'user_id' => $this->user_id,
            'service_delivered_status' => $this->service_delivered_status,
            'service_delivered_date' => $this->service_delivered_date,
            'invoice_generated_date' => $this->invoice_generated_date,
            'invoice_paid_date' => $this->invoice_paid_date,
            'plan_apply_date' => $this->plan_apply_date,
            'user_first_name' => $this->user_details->name,
            'user_last_name' => $this->user_details->last_name,
            'usertype' => $this->user_details->usertype,
            'property_security_deposit' =>$security_deposit,
            'property_security_deposit_value' =>$security_deposit *$expected_rent,
            'property_status'=>($this->property_status == null ? 'NO' :$this->property_status),
             'property_payment_status' =>($this->property_data == null ? 'NO' : $this->property_data->payment_status),
            'property_maintenance_charge' =>$maintenance_charge,
            'maintenance_charge_condition' =>($this->property_data == null ? null :($this->property_data->maintenance_charge_status=='0' ? 'No':$this->property_data->maintenance_condition->name)),
            'property_name' =>($this->property_data == null ? 'NO' : $this->property_data->build_name),
            'rent_aggrement_price' =>$rent_aggrement_price,
            'plan_aggrement_price' =>$plan_aggrement_price,
            'sgst_amount'=>$sgst,
           'cgst_amount'=>$cgst,
           'total_amount_owner(A)'=>$expected_rent+($security_deposit*$expected_rent)+$maintenance_charge,
            'Taxable_amount(B)' =>$plan_aggrement_price,
           'total_tax(C)'=>$sgst+$cgst,
           'total_amount'=>$plan_aggrement_price+$cgst+$sgst+$expected_rent+($security_deposit*$expected_rent)+$maintenance_charge,
         ];
        }
       
    }
}
