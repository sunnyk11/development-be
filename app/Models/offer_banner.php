<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offer_banner extends Model
{
    use HasFactory;

    protected $fillable = ['tittle','banner_status','start_date','end_date','text','status'];
}
