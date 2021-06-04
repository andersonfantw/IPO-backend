<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountReport extends Model
{
    protected $fillable = ['client_acc_id','status','make_report_time','sending_time','issued_by','remark'];
    protected $casts = [
        'make_report_time' => 'datetime:Y-m-d H:i:s',
        'sending_time' => 'datetime:Y-m-d H:i:s',
    ];
}
