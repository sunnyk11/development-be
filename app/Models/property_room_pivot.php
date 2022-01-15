<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_room_pivot extends Model
{
    use HasFactory;
    protected $fillable = [
       'room_id','product_id','status'
   ];
   
   public function room()
   {
       return $this->hasone('App\Models\property_room', 'id','room_id')->where('status', '1')->select('id','name');
   }
}
