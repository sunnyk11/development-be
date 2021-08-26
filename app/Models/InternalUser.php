<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalUser extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'branch', 'user_type', 'area_names', 'access_all_users', 'access_properties', 'access_requirements', 'access_reviews', 'access_lawyer_services', 'access_loan_control', 'access_user_creator', 'access_manage_blog'];
}
