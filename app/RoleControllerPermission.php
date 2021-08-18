<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleControllerPermission extends Model
{
    protected $table = 'role_controller_permissions';
    protected $fillable = [
        'role_id',
        'controller_id',
        'permission_id',
    ];

    public function Role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function Controller()
    {
        return $this->belongsTo('App\Controller', 'controller_id', 'id');
    }

    public function Permission()
    {
        return $this->belongsTo('App\Permission', 'permission_id', 'id');
    }
}
