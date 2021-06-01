<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientOverseasFundOutRequest extends Model
{
    protected $table = 'client_overseas_fund_out_requests';
    protected $fillable = [
        'uuid',
        'account_out',
        'amount',
        'bank',
        'swift_code',
        'account_in',
        'bank_address',
        'bank_address_text',
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

    public function ClientBankCard()
    {
        return $this->belongsTo('App\ClientBankCard', 'account_in', 'account_no');
    }
}
