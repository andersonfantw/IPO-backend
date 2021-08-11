<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'name',
    ];

    public function RoleFunctionPermission()
    {
        return $this->hasMany('App\RoleFunctionPermission', 'permission_id', 'id');
    }
}
