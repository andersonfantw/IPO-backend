<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientDepositIdentificationCode extends Model
{
    protected $table = 'client_deposit_identification_codes';
    protected $fillable = [
        'uuid',
        'identification_code',
    ];
}
