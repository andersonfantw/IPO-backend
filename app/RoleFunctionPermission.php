<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleFunctionPermission extends Model
{
    protected $table = 'role_function_permissions';
    protected $fillable = [
        'role_id',
        'function_id',
        'permission_id',
    ];

    public function Role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function _Function()
    {
        return $this->belongsTo('App\_Function', 'function_id', 'id');
    }

    public function Permission()
    {
        return $this->belongsTo('App\Permission', 'permission_id', 'id');
    }
}
