<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\tableAssist;

class CysislbGtsClientAcc extends Model
{
    use tableAssist;

    protected $table = 'cysislb_gts_client_acc';
    protected $primaryKey = 'sid';
    protected $fillable = [
        'client_acc_id',
        'name',
        'ae_code',
        'acc_type',
        'status',
        'loan_limit',
        'trading_limit',
        'ors_investor_id',
        'disallow_buy',
        'disallow_sell',
        'margin_ratio',
        'comm_rate',
        'min_commission',
        'email',
        'phone',
        'fax',
        'remark',
        'addr',
    ];

    public function scopeActive(Builder $query){
        return $this->where(function($query){
            $query->where('status','=','A')->orWhereRaw('length(client_acc_id)=8');
        });
    }
}
