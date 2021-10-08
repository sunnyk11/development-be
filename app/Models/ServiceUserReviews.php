<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUserReviews extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id','s_user_id','stars','content','status'];

    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    public function ServiceUser()
    {
        return $this->hasOne('App\Models\AreaServiceUser', 'user_id','s_user_id');
    }

}
