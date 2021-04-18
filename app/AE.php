<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AE extends Model
{
    protected $table = 'ae';
    protected $fillable = [
        'uuid',
        'name',
        'account_type',
        'code',
    ];
}
