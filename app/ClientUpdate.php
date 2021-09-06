<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientUpdate extends Model
{
    protected $table = 'client_updates';
    protected $fillable = [
        'uuid',
        'email',
        'country_code',
        'mobile',
        'education_level',
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
