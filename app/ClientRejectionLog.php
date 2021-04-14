<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientRejectionLog extends Model
{
    protected $table = 'client_rejection_log';
    protected $fillable = [
        'uuid',
        'rejected_section',
        'remark',
    ];
}
