<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class loans extends Model
{
    use HasFactory, HasApiTokens;


    protected $fillable = [
        'bank',
        'address',
        'interest_rate',
        'type',
        'delete_flag'
    ];

}
