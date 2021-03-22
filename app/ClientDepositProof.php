<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientDepositProof extends Model
{
    protected $table = 'client_deposit_proof';
    protected $fillable = [
        'uuid',
        'image',
        'deposit_account',
        'deposit_amount',
        'deposit_bank',
        'deposit_method',
        'other_deposit_method',
        'transfer_time',
        'timezone',
        'editable',
    ];
}
