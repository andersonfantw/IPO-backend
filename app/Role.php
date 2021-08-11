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

    public function RoleFunctionPermission()
    {
        return $this->hasMany('App\RoleFunctionPermission', 'role_id', 'id');
    }
}
