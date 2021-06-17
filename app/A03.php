<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\tableAssist;

class A03 extends Model
{
    use tableAssist;
    
    protected $table = 'a_client_product_balance_csv03';
    protected $primaryKey = 'sid';
    protected $fillable = [
        'client_acc_id',
        'market_id',
        'product_id',
        'product_code',
        'product_name',
        'product_group',
        'contract_info',
        'expiry_date',
        'status',
        'ccy',
        'settle_ccy',
        'product_amt_factor',
        'nominal',
        'closing_price',
        'orig_loan_ratio',
        'mv_rounding',
        'loan_ratio',
        'buss_date',
        'buss_date_1',
        'buss_date_2',
        'buss_date_3',
        'prev_qty',
        't0_qty',
        't1_qty',
        't2_qty',
        't3_qty',
        't0_unavail_qty',
        't0_uncleared_qty',
        't0_onhold_qty',
        't1_uncleared_qty',
        't1_onhold_qty',
        'net_avail_qty',
        'qty',
        't0_nominee_qty',
        'nominee_qty',
        't0_non_nominee_qty',
        'non_nominee_qty',
        'bonus_qty',
        'under_reg_qty',
        't0_settle_qty',
        't1_settle_qty',
        't1_after_settle_qty',
        't2_settle_qty',
        't3_settle_qty',
        'settle_qty',
        'prev_mv',
        't0_mv',
        't1_mv',
        't2_mv',
        't3_mv',
        'mv',
        'short_mv',
        'prev_all_mv',
        't0_all_mv',
        't1_all_mv',
        't2_all_mv',
        't3_all_mv',
        'all_mv',
        'short_all_mv',
        'cash_ac_factor',
        'dvp_ac_factor',
        'margin_ac_factor',
        'house_ac_factor',
        'avg_price',
        'short_sell_qty',
        'ss_interest',
        'rt_mv',
        't0_avail_qty',
        'prev_lv',
        't0_lv',
        't1_lv',
        't2_lv',
        't3_lv',
        'lv',
        'prev_orig_lv',
        't0_orig_lv',
        't1_orig_lv',
        't2_orig_lv',
        't3_orig_lv',
        'orig_lv',
        'rt_lv',
        'group_key',
        'neg_qty',
        'ae_code',
        'client_acc_name',
        't0_base_mv',
        't1_base_mv',
        'base_mv',
        'base_all_mv',
        'base_t0_all_mv',
        'cash_base_t0_mv',
        'dvp_base_t0_mv',
        'margin_base_t0_mv',
        'house_base_t0_mv',
        'cash_base_mv',
        'dvp_base_mv',
        'margin_base_mv',
        'house_base_mv',
        'cash_base_all_mv',
        'dvp_base_all_mv',
        'margin_base_all_mv',
        'house_base_all_mv',
        'cash_base_t0_all_mv',
        'dvp_base_t0_all_mv',
        'margin_base_t0_all_mv',
        'house_base_t0_all_mv',
        'cash_nominee_qty',
        'dvp_nominee_qty',
        'margin_nominee_qty',
        'house_nominee_qty',
        'cash_net_avail_qty',
        'dvp_net_avail_qty',
        'margin_net_avail_qty',
        'house_net_avail_qty',
        'cash_t0_unavail_qty',
        'dvp_unavail_qty',
        'margin_t0_unavail_qty',
        'house_t0_unavail_qty',
        'cash_qty',
        'dvp_qty',
        'margin_qty',
        'house_qty',
        'cash_t1_settle_qty',
        'dvp_t1_settle_qty',
        'margin_t1_settle_qty',
        'house_t1_settle_qty',
        'cash_t1_after_settle_qty',
        'dvp_t1_after_settle_qty',
        'margin_t1_after_settle_qty',
        'house_t1_after_settle_qty',
        'cash_t1_qty',
        'dvp_t1_qty',
        'margin_t1_qty',
        'house_t1_qty',
        'cash_t0_qty',
        'dvp_t0_qty',
        'margin_t0_qty',
        'house_t0_qty',
        'gl_rate',
        'mktv',
    ];

    public static function getTableColumns() {
        $instance = new static;
        return $instance->getConnection()->getSchemaBuilder()->getColumnListing($instance->getTable());
    }
}