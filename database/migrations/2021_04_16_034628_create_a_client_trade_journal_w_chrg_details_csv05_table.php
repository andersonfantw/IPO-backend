<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAClientTradeJournalWChrgDetailsCsv05Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'a_client_trade_journal_w_chrg_details_csv05';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->bigIncrements('sid');
                $table->decimal('net_amt1', 22, 6)->nullable();
                $table->string('tran_id', 50)->nullable(false)->index();
                $table->date('buss_date')->nullable()->index();
                $table->date('tran_date')->nullable()->index();
                $table->date('value_date')->nullable();
                $table->string('status', 20)->nullable();
                $table->integer('client_acc_id')->unsigned()->nullable(false)->index();
                $table->string('custodian_acc_id', 20)->nullable();
                $table->string('bs_flag', 5)->nullable();
                $table->string('product_id', 20)->nullable(false)->index();
                $table->string('input_channel', 20)->nullable();
                $table->string('trade_tran_type', 20)->nullable();
                $table->decimal('avg_price', 22, 6)->nullable();
                $table->integer('qty')->unsigned()->nullable();
                $table->string('avg_price_type', 20)->nullable();
                $table->decimal('gross_amt', 22, 6)->nullable();
                $table->decimal('actual_gc', 22, 6)->nullable();
                $table->decimal('commission', 22, 6)->nullable();
                $table->decimal('ae_commission', 22, 6)->nullable();
                $table->decimal('charge', 22, 6)->nullable();
                $table->decimal('net_amt', 22, 6)->nullable();
                $table->string('ex_rate', 100)->nullable();
                $table->decimal('net_settle_amt', 22, 6)->nullable();
                $table->decimal('broker_cost', 22, 6)->nullable();
                $table->string('comm_formula_id', 50)->nullable();
                $table->string('broker_code', 50)->nullable();
                $table->string('remark', 255)->nullable();
                $table->date('cancel_buss_date')->nullable();
                $table->datetime('cancel_time')->nullable();
                $table->string('cancel_user', 20)->nullable();
                $table->string('old_tran_id', 50)->nullable();
                $table->datetime('create_time')->nullable();
                $table->string('create_user', 20)->nullable();
                $table->datetime('confirm_time')->nullable();
                $table->string('confirm_user', 20)->nullable();
                $table->tinyInteger('num_of_trades')->nullable();
                $table->string('ae_code', 10)->nullable();
                $table->string('auto_gen_type', 50)->nullable();
                $table->string('auto_gen_tran_id', 50)->nullable();
                $table->decimal('prepaid_amt', 22, 6)->nullable();
                $table->integer('open_qty')->nullable();
                $table->string('order_no', 50)->nullable();
                $table->string('sett_ccy', 50)->nullable();
                $table->integer('day_trade_qty')->nullable();
                $table->decimal('day_trade_comm_rebate', 22, 6)->nullable();
                $table->string('recalc_trade', 100)->nullable();
                $table->decimal('settle_ccy_ex_rate', 22, 6)->nullable();
                $table->date('trade_expiry_date')->nullable();
                $table->string('liquidation_mode', 50)->nullable();
                $table->string('trade_type', 50)->nullable();
                $table->string('reference', 50)->nullable();
                $table->string('reference1', 50)->nullable();
                $table->string('archived', 50)->nullable();
                $table->string('is_settled', 50)->nullable();
                $table->string('min_commission', 50)->nullable();
                $table->decimal('comm_rate', 22, 6)->nullable();
                $table->string('order_type', 50)->nullable();
                $table->decimal('order_price', 22, 6)->nullable();
                $table->integer('order_qty')->nullable();
                $table->datetime('req_cancel_time')->nullable();
                $table->string('req_cancel_user', 20)->nullable();
                $table->date('req_cancel_buss_date')->nullable();
                $table->date('order_input_date')->nullable();
                $table->string('commission_ccy', 10)->nullable();
                $table->string('charge_ccy', 10)->nullable();
                $table->decimal('commission_ccy_ex_rate', 22, 6)->nullable();
                $table->decimal('charge_ccy_ex_rate', 22, 6)->nullable();
                $table->string('product_ccy', 10)->nullable();
                $table->date('jp_tran_date')->nullable();
                $table->date('jp_value_date')->nullable();
                $table->datetime('exec_time')->nullable();
                $table->string('exch_order_info', 50)->nullable();
                $table->string('bank_broker_trade_no', 50)->nullable();
                $table->decimal('official_rate', 22, 6)->nullable();
                $table->string('group_key', 5)->nullable();
                $table->string('client_acc_name', 50)->nullable();
                $table->string('product_name', 50)->nullable();
                $table->string('quote_ccy', 10)->nullable();
                $table->decimal('buy_gross_amt', 22, 6)->nullable();
                $table->decimal('sell_gross_amt', 22, 6)->nullable();
                $table->decimal('buy_commission', 22, 6)->nullable();
                $table->decimal('sell_commission', 22, 6)->nullable();
                $table->decimal('buy_ae_commission', 22, 6)->nullable();
                $table->decimal('sell_ae_commission', 22, 6)->nullable();
                $table->decimal('buy_broker_cost', 22, 6)->nullable();
                $table->decimal('sell_broker_cost', 22, 6)->nullable();
                $table->decimal('buy_net_amt', 22, 6)->nullable();
                $table->decimal('sell_net_amt', 22, 6)->nullable();
                $table->decimal('cash_gross_amt', 22, 6)->nullable();
                $table->decimal('dvp_gross_amt', 22, 6)->nullable();
                $table->decimal('margin_gross_amt', 22, 6)->nullable();
                $table->decimal('staff_gross_amt', 22, 6)->nullable();
                $table->decimal('house_gross_amt', 22, 6)->nullable();
                $table->decimal('other_acctype_gross_amt', 22, 6)->nullable();
                $table->decimal('other_acctype_gross_amt_2', 22, 6)->nullable();
                $table->decimal('cash_commission', 22, 6)->nullable();
                $table->decimal('dvp_commission', 22, 6)->nullable();
                $table->decimal('margin_commission', 22, 6)->nullable();
                $table->decimal('staff_commission', 22, 6)->nullable();
                $table->decimal('house_commission', 22, 6)->nullable();
                $table->decimal('other_acctype_commission', 22, 6)->nullable();
                $table->decimal('other_acctype_commission_2', 22, 6)->nullable();
                $table->decimal('cash_ae_commission', 22, 6)->nullable();
                $table->decimal('dvp_ae_commission', 22, 6)->nullable();
                $table->decimal('margin_ae_commission', 22, 6)->nullable();
                $table->decimal('staff_ae_commission', 22, 6)->nullable();
                $table->decimal('house_ae_commission', 22, 6)->nullable();
                $table->decimal('other_acctype_ae_commission', 22, 6)->nullable();
                $table->decimal('other_acctype_ae_commission_2', 22, 6)->nullable();
                $table->decimal('cash_broker_cost', 22, 6)->nullable();
                $table->decimal('dvp_broker_cost', 22, 6)->nullable();
                $table->decimal('margin_broker_cost', 22, 6)->nullable();
                $table->decimal('staff_broker_cost', 22, 6)->nullable();
                $table->decimal('house_broker_cost', 22, 6)->nullable();
                $table->decimal('other_acctype_broker_cost', 22, 6)->nullable();
                $table->decimal('other_acctype_broker_cost_2', 22, 6)->nullable();
                $table->decimal('cash_net_amt', 22, 6)->nullable();
                $table->decimal('dvp_net_amt', 22, 6)->nullable();
                $table->decimal('margin_net_amt', 22, 6)->nullable();
                $table->decimal('staff_net_amt', 22, 6)->nullable();
                $table->decimal('house_net_amt', 22, 6)->nullable();
                $table->decimal('other_acctype_net_amt', 22, 6)->nullable();
                $table->decimal('other_acctype_net_amt_2', 22, 6)->nullable();
                $table->string('ae_name', 100)->nullable();
                $table->string('order_no_yxsf', 50)->nullable();
                $table->string('bs_flag_2', 5)->nullable();
                $table->string('market_id', 10)->nullable();
                $table->string('otc', 50)->nullable();
                $table->string('acc_type', 5)->nullable();
                $table->string('tran_id_c', 20)->nullable();
                $table->decimal('c1', 22, 6)->nullable();
                $table->decimal('c2', 22, 6)->nullable();
                $table->decimal('c3', 22, 6)->nullable();
                $table->decimal('c4', 22, 6)->nullable();
                $table->decimal('c5', 22, 6)->nullable();
                $table->decimal('oth', 22, 6)->nullable();
                $table->decimal('cash_c1', 22, 6)->nullable();
                $table->decimal('dvp_c1', 22, 6)->nullable();
                $table->decimal('margin_c1', 22, 6)->nullable();
                $table->decimal('staff_c1', 22, 6)->nullable();
                $table->decimal('house_c1', 22, 6)->nullable();
                $table->decimal('other_acctype_c1', 22, 6)->nullable();
                $table->decimal('other_acctype_c1_2', 22, 6)->nullable();
                $table->decimal('cash_c2', 22, 6)->nullable();
                $table->decimal('dvp_c2', 22, 6)->nullable();
                $table->decimal('margin_c2', 22, 6)->nullable();
                $table->decimal('staff_c2', 22, 6)->nullable();
                $table->decimal('house_c2', 22, 6)->nullable();
                $table->decimal('other_acctype_c2', 22, 6)->nullable();
                $table->decimal('other_acctype_c2_2', 22, 6)->nullable();
                $table->decimal('cash_c3', 22, 6)->nullable();
                $table->decimal('dvp_c3', 22, 6)->nullable();
                $table->decimal('margin_c3', 22, 6)->nullable();
                $table->decimal('staff_c3', 22, 6)->nullable();
                $table->decimal('house_c3', 22, 6)->nullable();
                $table->decimal('other_acctype_c3', 22, 6)->nullable();
                $table->decimal('other_acctype_c3_2', 22, 6)->nullable();
                $table->decimal('cash_c4', 22, 6)->nullable();
                $table->decimal('dvp_c4', 22, 6)->nullable();
                $table->decimal('margin_c4', 22, 6)->nullable();
                $table->decimal('staff_c4', 22, 6)->nullable();
                $table->decimal('house_c4', 22, 6)->nullable();
                $table->decimal('other_acctype_c4', 22, 6)->nullable();
                $table->decimal('other_acctype_c4_2', 22, 6)->nullable();
                $table->decimal('cash_c5', 22, 6)->nullable();
                $table->decimal('dvp_c5', 22, 6)->nullable();
                $table->decimal('margin_c5', 22, 6)->nullable();
                $table->decimal('staff_c5', 22, 6)->nullable();
                $table->decimal('house_c5', 22, 6)->nullable();
                $table->decimal('other_acctype_c5', 22, 6)->nullable();
                $table->decimal('other_acctype_c5_2', 22, 6)->nullable();
                $table->decimal('cash_oth', 22, 6)->nullable();
                $table->decimal('dvp_oth', 22, 6)->nullable();
                $table->decimal('margin_oth', 22, 6)->nullable();
                $table->decimal('staff_oth', 22, 6)->nullable();
                $table->decimal('house_oth', 22, 6)->nullable();
                $table->decimal('other_acctype_oth', 22, 6)->nullable();
                $table->decimal('other_acctype_oth_2', 22, 6)->nullable();
                $table->decimal('buy_c1', 22, 6)->nullable();
                $table->decimal('sell_c1', 22, 6)->nullable();
                $table->decimal('buy_c2', 22, 6)->nullable();
                $table->decimal('sell_c2', 22, 6)->nullable();
                $table->decimal('buy_c3', 22, 6)->nullable();
                $table->decimal('sell_c3', 22, 6)->nullable();
                $table->decimal('buy_c4', 22, 6)->nullable();
                $table->decimal('sell_c4', 22, 6)->nullable();
                $table->decimal('buy_c5', 22, 6)->nullable();
                $table->decimal('sell_c5', 22, 6)->nullable();
                $table->decimal('buy_oth', 22, 6)->nullable();
                $table->decimal('sell_oth', 22, 6)->nullable();
                $table->timestamps();
                $table->unique(['tran_id','client_acc_id','product_id'],'unique1');
            });

            Schema::table($table_name, function (Blueprint $table) use($table_name) {
                DB::statement('ALTER TABLE '.$table_name.' MODIFY COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP');
                DB::statement('ALTER TABLE '.$table_name.' MODIFY COLUMN updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('a_client_trade_journal_w_chrg_details_csv05');
    }
}
