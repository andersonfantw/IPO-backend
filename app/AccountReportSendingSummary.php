<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
class AccountReportSendingSummary extends Model
{
    protected $table = 'account_report_sending_summary';
    protected $fillable = ['ipo_activity_period_id','start_date','end_date','report_make_date','performance_fee_date','report','issued_by','remark'];
    protected $dates = [
        'start_date',
        'end_date',
        'report_make_date',
        'performance_fee_date',
    ];

    public function AccountReport(){
        return $this->hasMany('APP\AccountReport');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
}
