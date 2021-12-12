<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class backend_reviews_user extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id','s_user_id','stars','content','status'];

    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    public function ServiceUser()
    {
        return $this->hasOne('App\Models\service_userlist', 'user_id','s_user_id');
    }
}
