<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientBankCard extends Model
{
    protected $table = 'client_bankcard';
    protected $fillable = [
        'uuid',
        'type',
        'lcid',
        'bank_name',
        'bank_code',
        'currency',
        'account_no',
        'backcard_face',
        'bankcard_blob',
        'issued_by',
        'status',
        'remark',
        'count_of_audits',
        'closed_at',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
