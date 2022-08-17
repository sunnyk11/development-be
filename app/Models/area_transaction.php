<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area_transaction extends Model
{
    use HasFactory;
      protected $fillable = [
        'table_name','old_column','new_column','action','updated_user','status'
    ];
}
