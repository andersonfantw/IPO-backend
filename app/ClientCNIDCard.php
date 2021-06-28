<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCNIDCard extends Model
{
    protected $table = 'client_cn_idcard';
    protected $fillable = [
        'uuid',
        'type',
        'idcard_face',
        'idcard_back',
        'nationality',
        'gender',
        'birthday',
        'name_c',
        'surname',
        'given_name',
        'idcard_no',
        'idcard_address',
        'issued_by',
        'valid_date',
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
