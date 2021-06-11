<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AccountReport extends Model
{
    protected $fillable = ['account_report_sending_summary_id','client_acc_id','status','report_queue_time','make_report_time','make_report_status','sending_queue_time','sending_time','sending_status','issued_by','remark'];
    protected $casts = [
        'make_report_time' => 'datetime:Y-m-d H:i:s',
        'sending_time' => 'datetime:Y-m-d H:i:s',
    ];

    public function AccountReportSendingSummary(){
        return $this->belongsTo('App\AccountReportSendingSummary');
    }

    public function ClientInfo(){
        return $this->hasOne('App\CysislbGtsClientAcc','client_acc_id','client_acc_id');
    }

    public function ViewClient(){
        return $this->hasOne('App\ViewClient','account_no','client_acc_id');
    }

    public function scopeOfParentID(Builder $query, $id){
        return $query->where('account_report_sending_summary_id','=',$id);
    }

    public function scopeOfReportStatus(Builder $query, $status){
        return $query->where('make_report_status','=',$status);
    }

    public function scopeOfSendingStatus(Builder $query, $status){
        return $query->where('sending_status','=',$status);
    }
}
