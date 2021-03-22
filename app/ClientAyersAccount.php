<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAyersAccount extends Model
{
    protected $table = 'client_ayers_account';
    protected $fillable = [
        'uuid',
        'account_no',
        'type',
        'status',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
