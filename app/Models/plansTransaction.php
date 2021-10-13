<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plansTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'MID',
        'transaction_id',
        'transaction_amount',
        'transaction_date',
        'transaction_status',
        'respcode',
        'resp_message',
        'gatewayname',
        'bank_txn_id',
        'bank_name',
        'checksumhash',
        'paymentmode',
        'currency',
        'retryAllowed',
        'errorMessage',
        'errorCode',
    ];
}
