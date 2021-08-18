<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Controller extends Model
{
    protected $table = 'controllers';
    protected $fillable = [
        'name',
    ];

    public function RoleControllerPermission()
    {
        return $this->hasMany('App\RoleControllerPermission', 'controller_id', 'id');
    }
}
