<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class invoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function toArray($request)
    {
        return [
            'user_email'=> $this->user_email,
            'user_id'=>$this->user_id,
            'order_id' => $this->order_id,
            'invoice_no' => $this->invoice_no,
            'invoice_id'=>$this->id,
            'plan_type' => $this->plan_type,
            'plan_name' => $this->plan_name,
            'plan_status' => $this->plan_status,
            'payment_type' => $this->payment_type,
            'plan_price' => $this->plan_price,
            'payment_status' => $this->payment_status,
            'payment_mode' => $this->payment_mode,
            'payment_received' => $this->payment_received,
            'property_id' =>($this->product_id == null ? null :$this->product_id),
            'property_name'=>($this->product_name == null ? null :$this->product_name),
            'property_price' => $this->property_amount,
            'propert_url'=>($this->product_id == null ? null : env('angular_url').'product-details?id='.$this->product_id),
            'gst_amount' => ($this->amount_paid == null ? null : ((9 * $this->plan_price) / 100)),
            'sgst_amount' => ($this->amount_paid == null ? null : ((9 * $this->plan_price) / 100)),
            'total_amount' => $this->amount_paid,
            'service_status' => $this->service_delivered_status,
            'service_delivered_date'=>($this->service_delivered_date == null ? null : date('Y-m-d H:i:s', strtotime($this->service_delivered_date. '+330 minutes'))),
            'Invoice_Generate_date' => date('Y-m-d H:i:s', strtotime($this->invoice_generated_date. '+330 minutes')),
            'Invoice_Paid_Date'=> ($this->invoice_paid_date == null ? null : date('Y-m-d H:i:s', strtotime($this->invoice_paid_date. '+330 minutes'))),
            'created_at' =>  date('Y-m-d H:i:s', strtotime($this->created_at. '+330 minutes')),
        ];
    }
}
