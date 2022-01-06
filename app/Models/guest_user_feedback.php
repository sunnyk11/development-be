<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guest_user_feedback extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id','product_id','stars','subject','content','status'];
    
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
}
