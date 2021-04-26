<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class A07 extends Model
{
    protected $table = 'a_interest_statement_csv07';
    protected $primaryKey = 'sid';
    protected $fillable = [
        'rank',
        'client_acc_id',
        'name',
        'ccy',
        'dayend_date',
        't0_amt',
        'interest_rate',
        'total_debit_interest',
        'credit_interest',
        'all_adj_interest',
        'total_interest',
        'posted_interest',
        'unposted_interest',
        'before_post_accrued',
        'credit_interest_rate',
        'debit_interest_rate',
        'margin_call_interest_rate',
        'debit_interest',
        'margin_call_interest',
        'dayend_credit_interest_rate',
        'dayend_debit_interest_rate',
        'dayend_margin_call_interest_rate',
        'dayend_debit_interest_val',
        'dayend_margin_call_val',
        'dayend_marginable_val',
    ];
}
