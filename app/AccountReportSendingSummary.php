<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountReportSendingSummary extends Model
{
    protected $table = 'account_report_sending_summary';
    protected $fillable = ['ipo_activity_period_id','start_date','end_date','report_make_date','performance_fee_date','report','issued_by','remark'];
    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
        'report_make_date' => 'datetime:Y-m-d',
        'performance_fee_date' => 'datetime:Y-m-d',
    ];

    public function AccountReport(){
        return $this->hasMany('APP\AccountReport');
    }
}
