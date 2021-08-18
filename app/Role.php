<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'name',
    ];

    public function UserRole()
    {
        return $this->hasMany('App\UserRole', 'role_id', 'id');
    }

    public function RoleControllerPermission()
    {
        return $this->hasMany('App\RoleControllerPermission', 'role_id', 'id');
    }

    public function RoleMenuItem()
    {
        return $this->hasMany('App\RoleMenuItem', 'role_id', 'id');
    }
}
