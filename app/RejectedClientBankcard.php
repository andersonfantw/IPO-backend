<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedClientBankcard extends Model
{
    protected $table = 'rejected_client_bankcards';
    protected $fillable = [
        'uuid',
        'lcid',
        'bank_name',
        'bank_code',
        'currency',
        'account_no',
        'bankcard_blob',
        'issued_by',
        'remark',
        'status',
    ];
}
