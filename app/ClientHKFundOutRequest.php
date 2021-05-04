<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientHKFundOutRequest extends Model
{
    protected $table = 'client_hk_fund_out_requests';
    protected $fillable = [
        'uuid',
        'account_out',
        'method',
        'amount',
        'bank',
        'account_in',
        'status',
        'transfer_time',
        'timezone',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
