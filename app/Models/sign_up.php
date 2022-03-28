<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class sign_up extends Model
{
    use HasFactory;
    protected $fillable = ['user_name','mobile_no','verify_code','verify_code_created_at','user_aggree','sign_up_page','status'];
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
