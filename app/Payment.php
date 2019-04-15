<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'description',
        'person',
        'total',
        'currency',
        'expiration',
        'return_url',
        'ip_address',
        'user_agent',
        'payment_status',
        'request_id',
        'process_url'
    ];
}
