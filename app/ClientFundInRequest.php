<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFundInRequest extends Model
{
    protected $table = 'client_fund_in_requests';
    protected $fillable = [
        'uuid',
        'bank',
        'bank_account',
        'account_in',
        'amount',
        'method',
        'status',
        'issued_by',
        'remark',
        'receipt',
        'bankcard',
        'transfer_time',
        'timezone',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
