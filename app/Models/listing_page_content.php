<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listing_page_content extends Model
{
    use HasFactory;
    protected $fillable = ['content','content_status','status'];
}
