<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    use HasFactory;

    protected $fillable = ['state_id', 'state', 'status'];

    public function districts() {
        return $this->hasMany(district::class, 'state_id', 'state_id');
    }
}
