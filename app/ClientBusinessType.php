<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientBusinessType extends Model
{
    protected $table = 'client_business_type';
    protected $fillable = [
        'uuid',
        'business_type',
        'agree_direct_promotion',
        'direct_promotion',
    ];
}
