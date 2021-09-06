<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientWorkingStatusUpdate extends Model
{
    protected $table = 'client_working_status_updates';
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
        'issued_by',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
