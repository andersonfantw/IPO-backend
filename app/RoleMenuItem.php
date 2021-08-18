<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleMenuItem extends Model
{
    protected $table = 'role_menu_items';
    protected $fillable = [
        'role_id',
        'menu_item_id',
    ];

    public function Role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function MenuItem()
    {
        return $this->belongsTo('App\MenuItem', 'menu_item_id', 'id');
    }
}
