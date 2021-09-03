<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnknownDeposit extends Model
{
    protected $table = 'unknown_deposits';
    protected $fillable = [
        'transaction_date',
        'value_date',
        'type',
        'summary',
        'remark',
        'identification_code',
        'amount_in',
        'balance',
        'voucher_no',
        'account_no',
        'account_name',
        'trading_place',
        'status',
        'uploaded_at',
    ];

    public function ClientDepositIdentificationCode()
    {
        return $this->belongsTo('App\ClientDepositIdentificationCode', 'identification_code', 'identification_code');
    }
}
