<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientOtherIDCardUpdate extends Model
{
    protected $table = 'client_other_idcard_updates';
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
        'issued_by',
        'closed_at',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
