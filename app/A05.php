<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\tableAssist;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class A05 extends Model
{
    use tableAssist;
    
    protected $table = 'a_client_trade_journal_w_chrg_details_csv05';
    protected $primaryKey = 'sid';
    protected $fillable = [
        'net_amt1',
        'tran_id',
        'buss_date',
        'tran_date',
        'value_date',
        'status',
        'client_acc_id',
        'custodian_acc_id',
        'bs_flag',
        'product_id',
        'input_channel',
        'trade_tran_type',
        'avg_price',
        'qty',
        'avg_price_type',
        'gross_amt',
        'actual_gc',
        'commission',
        'ae_commission',
        'charge',
        'net_amt',
        'ex_rate',
        'net_settle_amt',
        'broker_cost',
        'comm_formula_id',
        'broker_code',
        'remark',
        'cancel_buss_date',
        'cancel_time',
        'cancel_user',
        'old_tran_id',
        'create_time',
        'create_user',
        'confirm_time',
        'confirm_user',
        'num_of_trades',
        'ae_code',
        'auto_gen_type',
        'auto_gen_tran_id',
        'prepaid_amt',
        'open_qty',
        'order_no',
        'sett_ccy',
        'day_trade_qty',
        'day_trade_comm_rebate',
        'recalc_trade',
        'settle_ccy_ex_rate',
        'trade_expiry_date',
        'liquidation_mode',
        'trade_type',
        'reference',
        'reference1',
        'archived',
        'is_settled',
        'min_commission',
        'comm_rate',
        'order_type',
        'order_price',
        'order_qty',
        'req_cancel_time',
        'req_cancel_user',
        'req_cancel_buss_date',
        'order_input_date',
        'commission_ccy',
        'charge_ccy',
        'commission_ccy_ex_rate',
        'charge_ccy_ex_rate',
        'product_ccy',
        'jp_tran_date',
        'jp_value_date',
        'exec_time',
        'exch_order_info',
        'bank_broker_trade_no',
        'official_rate',
        'group_key',
        'client_acc_name',
        'product_name',
        'quote_ccy',
        'buy_gross_amt',
        'sell_gross_amt',
        'buy_commission',
        'sell_commission',
        'buy_ae_commission',
        'sell_ae_commission',
        'buy_broker_cost',
        'sell_broker_cost',
        'buy_net_amt',
        'sell_net_amt',
        'cash_gross_amt',
        'dvp_gross_amt',
        'margin_gross_amt',
        'staff_gross_amt',
        'house_gross_amt',
        'other_acctype_gross_amt',
        'other_acctype_gross_amt_2',
        'cash_commission',
        'dvp_commission',
        'margin_commission',
        'staff_commission',
        'house_commission',
        'other_acctype_commission',
        'other_acctype_commission_2',
        'cash_ae_commission',
        'dvp_ae_commission',
        'margin_ae_commission',
        'staff_ae_commission',
        'house_ae_commission',
        'other_acctype_ae_commission',
        'other_acctype_ae_commission_2',
        'cash_broker_cost',
        'dvp_broker_cost',
        'margin_broker_cost',
        'staff_broker_cost',
        'house_broker_cost',
        'other_acctype_broker_cost',
        'other_acctype_broker_cost_2',
        'cash_net_amt',
        'dvp_net_amt',
        'margin_net_amt',
        'staff_net_amt',
        'house_net_amt',
        'other_acctype_net_amt',
        'other_acctype_net_amt_2',
        'ae_name',
        'order_no_yxsf',
        'bs_flag_2',
        'market_id',
        'otc',
        'acc_type',
        'tran_id_c',
        'c1',
        'c2',
        'c3',
        'c4',
        'c5',
        'oth',
        'cash_c1',
        'dvp_c1',
        'margin_c1',
        'staff_c1',
        'house_c1',
        'other_acctype_c1',
        'other_acctype_c1_2',
        'cash_c2',
        'dvp_c2',
        'margin_c2',
        'staff_c2',
        'house_c2',
        'other_acctype_c2',
        'other_acctype_c2_2',
        'cash_c3',
        'dvp_c3',
        'margin_c3',
        'staff_c3',
        'house_c3',
        'other_acctype_c3',
        'other_acctype_c3_2',
        'cash_c4',
        'dvp_c4',
        'margin_c4',
        'staff_c4',
        'house_c4',
        'other_acctype_c4',
        'other_acctype_c4_2',
        'cash_c5',
        'dvp_c5',
        'margin_c5',
        'staff_c5',
        'house_c5',
        'other_acctype_c5',
        'other_acctype_c5_2',
        'cash_oth',
        'dvp_oth',
        'margin_oth',
        'staff_oth',
        'house_oth',
        'other_acctype_oth',
        'other_acctype_oth_2',
        'buy_c1',
        'sell_c1',
        'buy_c2',
        'sell_c2',
        'buy_c3',
        'sell_c3',
        'buy_c4',
        'sell_c4',
        'buy_c5',
        'sell_c5',
        'buy_oth',
        'sell_oth',
    ];

    public static function getTableColumns() {
        $instance = new static;
        return $instance->getConnection()->getSchemaBuilder()->getColumnListing($instance->getTable());
    }
}
