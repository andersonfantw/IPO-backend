<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFinancialStatusUpdate extends Model
{
    protected $table = 'client_financial_status_updates';
    protected $fillable = [
        'uuid',
        'fund_source',
        'other_fund_source',
        'annual_income',
        'net_assets',
        'status',
        'remark',
        'issued_by',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
