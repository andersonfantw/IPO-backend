<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'name',
    ];

    public function RoleControllerPermission()
    {
        return $this->hasMany('App\RoleControllerPermission', 'permission_id', 'id');
    }
}
