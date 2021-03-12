<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientSignature extends Model
{
    protected $table = 'client_signature';
    protected $fillable = [
        'uuid',
        'image',
    ];
}
