<?php

namespace App\Http\Resources\API\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class AllproductIMGResource extends JsonResource
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
            return [
                // 'Product_img_id' =>$this->id,
                '/storage/'.$this->image
                // 'Product_image' => $this->pluck('image')->implode(','),
                
                // 'Product_image' =>$this->image->pluck('image')->implode(','),
            ];
    }
}
