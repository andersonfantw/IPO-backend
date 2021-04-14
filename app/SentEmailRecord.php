<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SentEmailRecord extends Model
{
    protected $table = 'sent_email_records';
    protected $fillable = [
        'uuid',
        'type',
        'sent_by',
    ];
}
