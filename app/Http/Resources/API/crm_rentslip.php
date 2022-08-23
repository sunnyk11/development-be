<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;

class crm_rentslip extends JsonResource
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
        $plan_price=($this->property_invoice == null ? 'NO' : $this->property_invoice->plan_price);
        $cgst=round((($company_details->cgst *$plan_price) / 100));
        $sgst=round((($company_details->sgst *$plan_price) / 100));
         return [
            'expected_rent' => $this->expected_rent,
            'security_deposit' => $this->security_deposit,
            'security_deposit_value' => $this->security_deposit*$this->expected_rent,
            'maintenance_condition' => ($this->maintenance_charge_condition == null ? 'NO' : $this->maintenance_condition->name),
            'maintenance_charge'=>($this->maintenance_charge == null ? 0 : $this->maintenance_charge),
            'maintenance_charge_status'=>$this->maintenance_charge_status,
            'total_amount_owner(A)' =>$this->expected_rent+($this->security_deposit*$this->expected_rent)+ $this->maintenance_charge,
             'plan_name' => ($this->property_invoice == null ? 'NO' : $this->property_invoice->plan_name),
              'plan_type' => ($this->property_invoice == null ? null : $this->property_invoice->plan_type),
               'invoice_no' => ($this->property_invoice == null ? null : $this->property_invoice->invoice_no),
               'plan_price_taxable' => $plan_price+$cgst+$sgst,
               'product_payment_details'=>($this->product_payment_details == null ? null : $this->product_payment_details->payment_status),
            'plan_price_taxable(B)' => $plan_price+$cgst+$sgst,
            'final_payment(A-B)'=> ($this->expected_rent+($this->security_deposit*$this->expected_rent)+ $this->maintenance_charge)-($plan_price+$cgst+$sgst),
        ];
    }
}
