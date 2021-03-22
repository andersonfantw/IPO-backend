<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientBankCard extends Model
{
    protected $table = 'client_bankcard';
    protected $fillable = [
        'uuid',
        'bank_name',
        'currency',
        'account_no',
        'backcard_face',
        'status',
        'remark',
        'count_of_audits',
        'editable',
    ];
}
