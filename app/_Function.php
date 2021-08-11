<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _Function extends Model
{
    protected $table = 'functions';
    protected $fillable = [
        'name',
    ];

    public function RoleFunctionPermission()
    {
        return $this->hasMany('App\RoleFunctionPermission', 'function_id', 'id');
    }
}
