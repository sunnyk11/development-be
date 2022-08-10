<?php

namespace App\Http\Resources\API\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\Collaborator;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         return [
            'property_name' => $this->build_name,
            'property_price' => $this->expected_rent,
            'owner_email' =>($this->letout_invoice == null ? 'NO' :$this->letout_invoice->UserDetail->email),
            'owner_mobile' => ($this->letout_invoice == null ? 'NO' :$this->letout_invoice->UserDetail->other_mobile_number),
            'owner_invoice' => ($this->letout_invoice == null ? 'NO' :$this->letout_invoice->invoice_no),

            'customer_email' =>($this->rent_invoice == null ? 'NO' :$this->rent_invoice->UserDetail->email),
            'customer_mobile' => ($this->rent_invoice == null ? 'NO' :$this->rent_invoice->UserDetail->other_mobile_number),
            'customer_invoice' => ($this->rent_invoice == null ? 'NO' :$this->rent_invoice->invoice_no),
            'location'=>($this->product_sub_locality == null ? null :$this->product_sub_locality->sub_locality).'('.($this->product_locality == null ? null :$this->product_locality->locality).')',
            'Porperty_status'=>($this->order_status == 0 ? 'Letout' :'Rentout'),
        ];
    }
}
