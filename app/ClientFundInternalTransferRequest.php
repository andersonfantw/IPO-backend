<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFundInternalTransferRequest extends Model
{
    protected $table = 'client_fund_internal_transfer_requests';
    protected $fillable = [
        'uuid',
        'account_in',
        'account_out',
        'amount',
        'status',
        'issued_by',
        'remark',
        'transfer_time',
        'timezone',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
