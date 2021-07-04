<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedClientCreditCard extends Model
{
    protected $table = 'rejected_client_credit_cards';
    protected $fillable = [
        'uuid',
        'card_no',
        'owner_name',
        'expiry_date',
        'card_issuer',
        'card_blob',
        'issued_by',
        'status',
        'remark',
    ];
}
