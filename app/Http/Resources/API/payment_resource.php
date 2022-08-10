<?php

namespace App\Http\Resources\API;
use Carbon\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class payment_resource extends JsonResource
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
            'transaction_id'=>$this->transaction_id,
            'amount'=>$this->amount,
            'payment_status'=>$this->payment_status,
            'property_name'=> ($this->productdetails == null ? 'No' :  $this->productdetails->build_name ),
            'property_owner'=> ($this->pro_owner == null ? 'No' :  $this->pro_owner->name),
            'created_user'=> ($this->pro_created_user == null ? 'No' :  $this->pro_created_user->name),
            'created_at' =>  date('Y-m-d H:i:s', strtotime($this->created_at. '+330 minutes')),
            
        ];
    }
}
