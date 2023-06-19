<?php

namespace App\Http\Resources\API\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\Collaborator;
use App\Http\Resources\API\Product\AllproductIMGResource;

class AllproductResource extends JsonResource
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
        return[
        'property_id' => $this->id,
        'property_url'=>"https://www.housingstreet.com/product-details?id=".$this->id,
        'property_name' => $this->build_name,
        'property_price' => $this->expected_rent,
        'property_detail'=>$this->property_detail,
        'address'=>$this->address,
        'address_details'=>$this->address_details,
        'map_latitude'=>$this->map_latitude,
        'map_longitude'=>$this->map_longitude,
        'bedroom'=>$this->bedroom,
        'bathroom'=>$this->bathroom,
        'balconies'=>$this->balconies,
        'product_image' =>$this->product_img == null ? 'NO' :AllproductIMGResource::collection($this->product_img),
        'security_deposit'=>$this->security_deposit,
        'area_unit' =>($this->Property_area_unit == '0' ? 'NO' :$this->area),
        'property_type'=>($this->pro_flat_Type == null ? 'NO' :$this->pro_flat_Type->name),
        'furnishing_status' =>($this->furnishing_status == 0 ? 'NO' :'Yes'),
        // 'owner_mobile' => ($this->letout_invoice == null ? 'NO' :$this->letout_invoice->UserDetail->other_mobile_number),
        // 'owner_invoice' => ($this->letout_invoice == null ? 'NO' :$this->letout_invoice->invoice_no),

        // 'customer_email' =>($this->purchase_property == null ? 'NO' :$this->purchase_property->UserDetail->email),
        // 'customer_mobile' => ($this->purchase_property == null ? 'NO' :$this->purchase_property->UserDetail->other_mobile_number),
        // 'customer_rented_invoice' => ($this->purchase_property == null ? 'NO' :$this->purchase_property->invoice_no),
        // 'customer_book_invoice' => ($this->book_property == null ? 'NO' :$this->book_property->admin_purchase_property->invoice_no).'('. ($this->book_property == null ? 'No Other invoice' :$this->book_property->invoice_no).')',
        'product_state' => $this->product_state == null ? 'No': $this->product_state->state,
        'product_district' =>$this->product_district == null ? 'No': $this->product_district->district,
        'product_locality' =>$this->product_locality == null ? 'No': $this->product_locality->locality,
        'product_sub_locality' =>$this->product_sub_locality == null ? 'No': $this->product_sub_locality->sub_locality,
        'property_draft_mode'=>$this->draft=='0' ? 'No':'Yes',
        'property_enabled'=>$this->enabled=='no' ? 'No':'Yes',
        'Porperty_status'=>($this->order_status == 0 ? 'Letout' :'Rentout'),
    ];
        
    }
}
