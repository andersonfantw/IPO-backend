<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCNIDCardUpdate extends Model
{
    protected $table = 'client_cn_idcard_updates';
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
        'closed_at',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
