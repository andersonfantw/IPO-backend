<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCNIDCard extends Model
{
    protected $table = 'client_cn_idcard';
    protected $fillable = [
        'uuid',
        'idcard_face',
        'idcard_back',
        'gender',
        'name_sc',
        'surname',
        'given_name',
        'idcard_no',
        'idcard_address',
        'status',
        'remark',
        'count_of_audits',
    ];

    public function client()
    {
        return $this->morphOne('App\Client', 'IDCard');
    }
}
