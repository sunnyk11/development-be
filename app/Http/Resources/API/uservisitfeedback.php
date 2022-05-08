<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class uservisitfeedback extends JsonResource
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
            'star_rating'=> $this->star_rating,
            'system_ip'=>$this->system_ip,
            'device_info' => $this->device_info,
            'message' => $this->message,
            'created_at' =>  date('Y-m-d H:i:s', strtotime($this->created_at. '+330 minutes')),
        ];
    }
}
