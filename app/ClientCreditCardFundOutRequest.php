<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCreditCardFundOutRequest extends Model
{
    protected $table = 'client_credit_card_fund_out_requests';
    protected $fillable = [
        'uuid',
        'account_out',
        'amount',
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

    public function ClientCreditCard()
    {
        return $this->belongsTo('App\ClientCreditCard', 'account_in', 'card_no');
    }
}
