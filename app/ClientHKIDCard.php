<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientHKIDCard extends Model
{
    protected $table = 'client_hk_idcard';
    protected $fillable = [
        'uuid',
        'idcard_face',
        'idcard_back',
        'name_tc',
        'name_en',
        'gender',
        'birthday',
        'idcard_no',
    ];

    public function client()
    {
        return $this->morphOne('App\Client', 'IDCard');
    }
}
