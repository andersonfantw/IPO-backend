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
        'issued_by',
        'remark',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }

    public function ClientBankCard()
    {
        return $this->belongsTo('App\ClientBankCard', 'account_in', 'account_no');
    }
}
