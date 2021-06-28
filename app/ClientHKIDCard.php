<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientHKIDCard extends Model
{
    protected $table = 'client_hk_idcard';
    protected $fillable = [
        'uuid',
        'type',
        'idcard_face',
        'idcard_back',
        'name_c',
        'name_en',
        'gender',
        'birthday',
        'idcard_no',
        'status',
        'remark',
        'count_of_audits',
        'closed_at',
    ];

    public function client()
    {
        return $this->morphOne('App\Client', 'IDCard');
    }
}
