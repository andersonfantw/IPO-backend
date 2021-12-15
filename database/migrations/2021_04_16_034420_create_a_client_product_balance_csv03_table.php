<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAClientProductBalanceCsv03Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'a_client_product_balance_csv03';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->bigIncrements('sid');
                $table->integer('client_acc_id')->unsigned()->nullable(false)->index();
                $table->string('market_id', 5)->nullable();
                $table->string('product_id', 20)->nullable(false)->index();
                $table->string('product_code', 10)->nullable();
                $table->string('product_name', 50)->nullable();
                $table->string('product_group', 50)->nullable();
                $table->string('contract_info', 50)->nullable();
                $table->date('expiry_date')->nullable();
                $table->string('status', 5)->nullable();
                $table->string('ccy', 10)->nullable();
                $table->string('settle_ccy', 10)->nullable();
                $table->string('product_amt_factor', 20)->nullable();
                $table->decimal('nominal', 22, 6)->nullable();
                $table->decimal('closing_price', 22, 6)->nullable();
                $table->decimal('orig_loan_ratio', 22, 6)->nullable();
                $table->decimal('mv_rounding', 22, 6)->nullable();
                $table->decimal('loan_ratio', 22, 6)->nullable();
                $table->date('buss_date')->nullable(false)->index();
                $table->date('buss_date_1')->nullable();
                $table->date('buss_date_2')->nullable();
                $table->date('buss_date_3')->nullable();
                $table->integer('prev_qty')->nullable();
                $table->integer('t0_qty')->nullable();
                $table->integer('t1_qty')->nullable();
                $table->integer('t2_qty')->nullable();
                $table->integer('t3_qty')->nullable();
                $table->integer('t0_unavail_qty')->nullable();
                $table->integer('t0_uncleared_qty')->nullable();
                $table->integer('t0_onhold_qty')->nullable();
                $table->integer('t1_uncleared_qty')->nullable();
                $table->integer('t1_onhold_qty')->nullable();
                $table->integer('net_avail_qty')->nullable();
                $table->integer('qty')->nullable();
                $table->integer('t0_nominee_qty')->nullable();
                $table->integer('nominee_qty')->nullable();
                $table->integer('t0_non_nominee_qty')->nullable();
                $table->integer('non_nominee_qty')->nullable();
                $table->integer('bonus_qty')->nullable();
                $table->integer('under_reg_qty')->nullable();
                $table->integer('t0_settle_qty')->nullable();
                $table->integer('t1_settle_qty')->nullable();
                $table->integer('t1_after_settle_qty')->nullable();
                $table->integer('t2_settle_qty')->nullable();
                $table->integer('t3_settle_qty')->nullable();
                $table->integer('settle_qty')->nullable();
                $table->decimal('prev_mv', 22, 6)->nullable();
                $table->decimal('t0_mv', 22, 6)->nullable();
                $table->decimal('t1_mv', 22, 6)->nullable();
                $table->decimal('t2_mv', 22, 6)->nullable();
                $table->decimal('t3_mv', 22, 6)->nullable();
                $table->decimal('mv', 22, 6)->nullable();
                $table->decimal('short_mv', 22, 6)->nullable();
                $table->decimal('prev_all_mv', 22, 6)->nullable();
                $table->decimal('t0_all_mv', 22, 6)->nullable();
                $table->decimal('t1_all_mv', 22, 6)->nullable();
                $table->decimal('t2_all_mv', 22, 6)->nullable();
                $table->decimal('t3_all_mv', 22, 6)->nullable();
                $table->decimal('all_mv', 22, 6)->nullable();
                $table->decimal('short_all_mv', 22, 6)->nullable();
                $table->tinyInteger('cash_ac_factor')->nullable();
                $table->tinyInteger('dvp_ac_factor')->nullable();
                $table->tinyInteger('margin_ac_factor')->nullable();
                $table->tinyInteger('house_ac_factor')->nullable();
                $table->decimal('avg_price', 22, 6)->nullable();
                $table->integer('short_sell_qty')->nullable();
                $table->decimal('ss_interest', 22, 6)->nullable();
                $table->decimal('rt_mv', 22, 6)->nullable();
                $table->integer('t0_avail_qty')->nullable();
                $table->decimal('prev_lv', 22, 6)->nullable();
                $table->decimal('t0_lv', 22, 6)->nullable();
                $table->decimal('t1_lv', 22, 6)->nullable();
                $table->decimal('t2_lv', 22, 6)->nullable();
                $table->decimal('t3_lv', 22, 6)->nullable();
                $table->decimal('lv', 22, 6)->nullable();
                $table->decimal('prev_orig_lv', 22, 6)->nullable();
                $table->decimal('t0_orig_lv', 22, 6)->nullable();
                $table->decimal('t1_orig_lv', 22, 6)->nullable();
                $table->decimal('t2_orig_lv', 22, 6)->nullable();
                $table->decimal('t3_orig_lv', 22, 6)->nullable();
                $table->decimal('orig_lv', 22, 6)->nullable();
                $table->decimal('rt_lv', 22, 6)->nullable();
                $table->string('group_key', 20)->nullable();
                $table->integer('neg_qty')->nullable();
                $table->string('ae_code', 20)->nullable();
                $table->string('client_acc_name', 50)->nullable();
                $table->decimal('t0_base_mv', 22, 6)->nullable();
                $table->decimal('t1_base_mv', 22, 6)->nullable();
                $table->decimal('base_mv', 22, 6)->nullable();
                $table->decimal('base_all_mv', 22, 6)->nullable();
                $table->decimal('base_t0_all_mv', 22, 6)->nullable();
                $table->decimal('cash_base_t0_mv', 22, 6)->nullable();
                $table->decimal('dvp_base_t0_mv', 22, 6)->nullable();
                $table->decimal('margin_base_t0_mv', 22, 6)->nullable();
                $table->decimal('house_base_t0_mv', 22, 6)->nullable();
                $table->decimal('cash_base_mv', 22, 6)->nullable();
                $table->decimal('dvp_base_mv', 22, 6)->nullable();
                $table->decimal('margin_base_mv', 22, 6)->nullable();
                $table->decimal('house_base_mv', 22, 6)->nullable();
                $table->decimal('cash_base_all_mv', 22, 6)->nullable();
                $table->decimal('dvp_base_all_mv', 22, 6)->nullable();
                $table->decimal('margin_base_all_mv', 22, 6)->nullable();
                $table->decimal('house_base_all_mv', 22, 6)->nullable();
                $table->decimal('cash_base_t0_all_mv', 22, 6)->nullable();
                $table->decimal('dvp_base_t0_all_mv', 22, 6)->nullable();
                $table->decimal('margin_base_t0_all_mv', 22, 6)->nullable();
                $table->decimal('house_base_t0_all_mv', 22, 6)->nullable();
                $table->integer('cash_nominee_qty')->nullable();
                $table->integer('dvp_nominee_qty')->nullable();
                $table->integer('margin_nominee_qty')->nullable();
                $table->integer('house_nominee_qty')->nullable();
                $table->integer('cash_net_avail_qty')->nullable();
                $table->integer('dvp_net_avail_qty')->nullable();
                $table->integer('margin_net_avail_qty')->nullable();
                $table->integer('house_net_avail_qty')->nullable();
                $table->integer('cash_t0_unavail_qty')->nullable();
                $table->integer('dvp_unavail_qty')->nullable();
                $table->integer('margin_t0_unavail_qty')->nullable();
                $table->integer('house_t0_unavail_qty')->nullable();
                $table->integer('cash_qty')->nullable();
                $table->integer('dvp_qty')->nullable();
                $table->integer('margin_qty')->nullable();
                $table->integer('house_qty')->nullable();
                $table->integer('cash_t1_settle_qty')->nullable();
                $table->integer('dvp_t1_settle_qty')->nullable();
                $table->integer('margin_t1_settle_qty')->nullable();
                $table->integer('house_t1_settle_qty')->nullable();
                $table->integer('cash_t1_after_settle_qty')->nullable();
                $table->integer('dvp_t1_after_settle_qty')->nullable();
                $table->integer('margin_t1_after_settle_qty')->nullable();
                $table->integer('house_t1_after_settle_qty')->nullable();
                $table->integer('cash_t1_qty')->nullable();
                $table->integer('dvp_t1_qty')->nullable();
                $table->integer('margin_t1_qty')->nullable();
                $table->integer('house_t1_qty')->nullable();
                $table->integer('cash_t0_qty')->nullable();
                $table->integer('dvp_t0_qty')->nullable();
                $table->integer('margin_t0_qty')->nullable();
                $table->integer('house_t0_qty')->nullable();
                $table->string('gl_rate', 50)->nullable();
                $table->string('mktv', 50)->nullable();
                $table->timestamps();
                $table->unique(['client_acc_id','product_id','buss_date'],'unique1');
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
        // Schema::dropIfExists('a_client_product_balance_csv03');
    }
}
