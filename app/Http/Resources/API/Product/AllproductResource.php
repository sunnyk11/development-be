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
        if($this->order_status == 1){
            $order_status='letout';
        }elseif($this->order_status == 2){
            $order_status='Rentout';
        }else{
            if($this->draft=='0'){
                $order_status='live';
            }else{
                $order_status='Not live';
            }
        }
        $url =$this->id.'&locality='.($this->product_locality == null ? 'No': $this->product_locality->locality).'&sub_locality='.($this->product_sub_locality == null ? 'No': $this->product_sub_locality->sub_locality).'&flat-type='.($this->pro_flat_Type == null ? 'No': $this->pro_flat_Type->name);

        // Replace spaces with "%20"
        $url = str_replace(' ', '%20', $url);
        $url = str_replace('=', '%3D', $url);

        // Replace ampersands with "%26"
        $url = str_replace('&', '%26', $url);
        return[
        'property_id' =>$this->id,
        'property_url'=> "https://www.housingstreet.com/product-details?id=".$url,
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
        'product_image' =>$this->product_img == null ? 'NO' :$this->product_img,
        'Availability_date' =>$this->available_for == null ? 'NO' :$this->available_for,
        'security_deposit'=>$this->security_deposit == null ? 'No':$this->security_deposit,
        'security_deposit_amount'=>$this->security_deposit == null ? 'No':$this->expected_rent*$this->security_deposit,
        'area' =>($this->area_unit == '0' ? 'NO' :( $this->Property_area_unit == null ? 'No':$this->area)),
        'area_unit' =>($this->area_unit == '0' ? 'NO' :( $this->Property_area_unit == null ? 'No':$this->Property_area_unit->unit)),
       'property_flat_type'=>($this->pro_flat_Type == null ? 'NO' :$this->pro_flat_Type->name),
       'property_type'=>($this->Property_Type == null ? 'NO' :$this->Property_Type->name),
        'simillar_property'=>($this->simlilar_property_id == null ? '' :$this->simlilar_property_id),
        'furnishing_status' =>($this->furnishing_status == 0 ? 'Not Furnished ' :'Furnished'),
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
        'property_type_status'=>$this->rent_availability=='1' ? 'Rent Property':'Sales Property',
        'Porperty_status'=> $order_status,
    ];
        
    }
}
