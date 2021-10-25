<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeGoCashInRecord extends Model
{
    protected $table = 'tradego_cash_in_records';
    protected $fillable = [
        'tran_date',
        'cash_in_date',
        'ccclnld',
        'bank_name',
        'bank_acc_id',
        'ccy',
        'amount',
        'remark',
        'create_time',
    ];
}
