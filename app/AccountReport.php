<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AccountReport extends Model
{
    protected $fillable = ['account_report_sending_summary_id','client_acc_id','status','make_report_time','sending_time','issued_by','remark'];
    protected $casts = [
        'make_report_time' => 'datetime:Y-m-d H:i:s',
        'sending_time' => 'datetime:Y-m-d H:i:s',
    ];

    public function AccountReportSendingSummary(){
        return $this->belongsTo('APP\AccountReportSendingSummary');
    }

    public function ClientInfo(){
        return $this->hasOne('App\CysislbGtsClientAcc','client_acc_id','client_acc_id');
    }

    public function scopeActive(Builder $query){
        return $query->where('status','=','A');
    }

    public function scopeOfParentID(Builder $query, $id){
        return $query->where('account_report_sending_summary_id','=',$id);
    }
}
