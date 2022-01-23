<?php

namespace App\Http\Resources\API\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
        // return parent::toArray($request);
        $current_date = Carbon::now()->format('Y-m-d');
        $datetime1 = date_create($current_date);

        $datetime2 = date_create($this->invoice_generated_date);
        $interval = date_diff($datetime1, $datetime2);
        $different = $interval->format('%d');
        $test= 30 - $different;
        return [
            'id' => $this->id,
            'different' => $test,
            'plan_name'=> $this->plan_name,
            'user_id' => $this->user_id,
            'address_details' => $this->address_details,
            'product_state' => $this->product_state,
            'product_locality' => $this->product_locality,   
            'tax_govt_charge' => $this->tax_govt_charge,
            'price_negotiable' => $this->price_negotiable,
            'negotiable_status' => $this->negotiable_status,
            'maintenance_charge_status' => $this->maintenance_charge_status,
            'maintenance_charge' => $this->maintenance_charge,
            'type' => $this->type,
            'bedroom' => $this->bedroom,
            'bathroom' => $this->bathroom,
            'balconies' => $this->balconies,
            'furnishing_status' => $this->furnishing_status,
            'expected_rent' => $this->expected_rent,
            'property_area_unit' => $this->property_area_unit,
            'build_name' => $this->build_name,
            'user_detail' => $this->user_detail,
            'property__type' => $this->property__type,
            'product_img' => $this->product_img,
            'product_uid' => $this->product_state,
        ];
    }
}
