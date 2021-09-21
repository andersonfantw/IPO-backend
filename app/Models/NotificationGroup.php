<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationGroup extends Model
{
    protected $fillable = ['route','notification_template_id','title','content','issued_by','import_list'];
}
