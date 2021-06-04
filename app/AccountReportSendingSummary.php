<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountReportSendingSummary extends Model
{
    protected $table = 'account_report_sending_summary';
    protected $fillable = ['ipo_activity_period_id','start_date','end_date','report_make_date','report','issued_by','remark'];
    protected $casts = [
        'start_date' => 'datetime:Y-m-d H:i:s',
        'end_date' => 'datetime:Y-m-d H:i:s',
        'report_make_date' => 'datetime:Y-m-d H:i:s',
    ];
}
