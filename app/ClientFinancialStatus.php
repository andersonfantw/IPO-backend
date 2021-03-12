<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFinancialStatus extends Model
{
    protected $table = 'client_financial_status';
    protected $fillable = [
        'uuid',
        'fund_source',
        'other_fund_source',
        'annual_income',
        'net_assets',
    ];
}
