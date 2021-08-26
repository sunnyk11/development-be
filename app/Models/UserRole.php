<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'role_id', 'access_all_users', 'access_properties', 'access_reviews', 'access_lawyer_services', 'access_loan_control', 'access_user_creator', 'access_manage_blog', 'access_manage_roles', 'access_list_property'];
}
