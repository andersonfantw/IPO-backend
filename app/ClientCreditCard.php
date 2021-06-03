<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCreditCard extends Model
{
    protected $table = 'client_credit_cards';
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
        'count_of_audits',
        'previewing_by',
        'closed_at',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
