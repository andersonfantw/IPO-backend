<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientBusinessTypeUpdate extends Model
{
    protected $table = 'client_business_type_updates';
    protected $fillable = [
        'uuid',
        'business_type',
        'agree_direct_promotion',
        'direct_promotion',
        'status',
        'remark',
        'issued_by',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
