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

    public function UnknownDeposit()
    {
        return $this->hasMany('App\UnknownDeposit', 'identification_code', 'identification_code');
    }

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
