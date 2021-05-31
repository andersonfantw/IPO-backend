<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtIpoSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'tt_ipo_summary';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->string('client_acc_id', 10)->nullable(false)->primary();
                $table->integer('ipo_activity_periods_id')->nullable();
                $table->date('ipo_activity_periods_start_date')->nullable();
                $table->date('ipo_activity_periods_end_date')->nullable();
                $table->string('prev_client', 1)->nullable();
                $table->string('init_table', 1)->nullable();
                $table->string('prev_program', 1)->nullable();
                $table->string('current_program', 1)->nullable();
                $table->date('init_value_date')->nullable();
                $table->decimal('init_value', 22, 6)->nullable();
                $table->date('performance_fee_date')->nullable();
                $table->decimal('performance_fee', 22, 6)->nullable();
                $table->date('transfer_profit_date')->nullable();
                $table->decimal('transfer_profit', 22, 6)->nullable();
                $table->date('rev_of_date')->nullable();
                $table->decimal('rev_of', 22, 6)->nullable();
                $table->date('start_value_date')->nullable();
                $table->decimal('start_value', 22, 6)->nullable();
                $table->decimal('rev_cash_withdraw', 22, 6)->nullable();
                $table->decimal('cost', 22, 6)->nullable();
                $table->decimal('settlement_amount', 22, 6)->nullable();
                $table->decimal('alloted_subscription', 22, 6)->nullable();
                $table->decimal('alloted_refund', 22, 6)->nullable();
                $table->decimal('alloted_loan_return', 22, 6)->nullable();
                $table->decimal('alloted_not_show', 22, 6)->nullable();
                $table->decimal('prev_subscription_alloted', 22, 6)->nullable();
                $table->decimal('prev_fee', 22, 6)->nullable();
                $table->decimal('transfer_hkd', 22, 6)->nullable();
                $table->decimal('total', 22, 6)->nullable();
                $table->decimal('avail_bal', 22, 6)->nullable();
                $table->string('avail_table', 1)->nullable();
                $table->boolean('result')->nullable();
                $table->decimal('diff', 22, 6)->nullable();
                $table->decimal('caculate_init_deposit', 22, 6)->nullable();
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
        Schema::dropIfExists('tt_ipo_summary');
    }
}
