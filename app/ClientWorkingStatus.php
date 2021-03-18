<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientWorkingStatus extends Model
{
    protected $table = 'client_working_status';
    protected $fillable = [
        'uuid',
        'working_status',
        'company_name',
        'company_tel',
        'school_name',
        'industry',
        'position',
        'name_card_face',
        'status',
        'remark',
        'count_of_audits',
    ];
}
