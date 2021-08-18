<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    protected $fillable = [
        'name',
    ];

    public function RoleMenuItem()
    {
        return $this->hasMany('App\RoleMenuItem', 'menu_item_id', 'id');
    }
}
