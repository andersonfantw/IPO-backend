<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\tableAssist;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class A01 extends Model
{
    use tableAssist;

    protected $table = 'a_client_fund_in_out_listing_csv01';
    protected $primaryKey = 'sid';
    protected $fillable = [
        'tran_type',
        'tran_sub_type',
        'tran_id',
        'status',
        'status_factor',
        'buss_date',
        'tran_date',
        'value_date',
        'avail_date', 
        'bank_acc_id',
        'payee_bank_info',
        'cheque_no',
        'client_acc_id', 
        'ccy',
        'amount_in',
        'amount_out',
        'amount',
        'orig_amount',
        'remark',
        'gl_mapping_item_id',
        'create_user',
        'create_time',
        'confirm_user',
        'confirm_time',
        'req_cancel_user',
        'req_cancel_time',
        'cancel_user',
        'cancel_time',
        'auto_gen_type',
        'auto_gen_tran_id',
        'same_day_cancel_flag',
        'back_date_flag',
        'cancelled',
        'other_name',
        'payee_name',
        'bank_code',
        'product_id',
        'input_channel',
        'client_acc_name',
        'create_user_name',
        'confirm_user_name',
        'acct_code_map_item',
        'avail_bal',
        'client_code',
    ];

    protected $casts = [
        'buss_date' => 'datetime:d-M-y'
    ];
}
