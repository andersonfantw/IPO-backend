<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function Role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }
}
