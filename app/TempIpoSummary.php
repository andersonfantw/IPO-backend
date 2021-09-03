<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempIpoSummary extends Model
{
    protected $table = 'tt_ipo_summary';
    protected $primaryKey = 'client_acc_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'init_value_date' => 'datetime:Y-m-d',
        'ipo_activity_periods_start_date' => 'datetime:Y-m-d',
    ];
}
