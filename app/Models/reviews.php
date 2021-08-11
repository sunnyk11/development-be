<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'property_name',
        'product_id',
        'stars',
        'rev_subject',
        'rev_content',

    ];
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }


}
