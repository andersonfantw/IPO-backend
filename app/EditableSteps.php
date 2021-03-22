<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditableSteps extends Model
{
    protected $table = 'editable_steps';
    protected $fillable = [
        'uuid',
        'step',
    ];
}
