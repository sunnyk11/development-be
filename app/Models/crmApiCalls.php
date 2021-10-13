<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crmApiCalls extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_body',
        'response_client_error',
        'response_fail',
        'response_server_error',
        'response_status',
        'response_success',
        'request_time',
        'response_time',
        'user_email',
        'user_phone',
        'user_name',
        'source'
    ];
}
