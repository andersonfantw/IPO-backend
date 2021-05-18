<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFundInRequest extends Model
{
    protected $table = 'client_fund_in_requests';
    protected $fillable = [
        'uuid',
        'account_no',
        'bank',
        'amount',
        'method',
        'status',
        'issued_by',
        'remark',
        'transfer_time',
        'timezone',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
