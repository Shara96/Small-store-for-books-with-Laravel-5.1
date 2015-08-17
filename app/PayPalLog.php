<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayPalLog extends Model
{
    protected $table = 'PayPalLogs';
    protected $fillable = [
        'payment_id',
        'viewed',
        'state',
        'paypal_id',
        'payer_email',
        'payer_id',
        'payer_first_name',
        'payer_last_name',
        'shipping_address',
        'item_list',
        'total',
    ];

}
