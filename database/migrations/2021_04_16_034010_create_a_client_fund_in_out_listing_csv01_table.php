<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAClientFundInOutListingCsv01Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'a_client_fund_in_out_listing_csv01';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->bigIncrements('sid');
                $table->string('tran_type', 20)->nullable(false)->index();
                $table->string('tran_sub_type', 20)->nullable(false)->index();
                $table->string('tran_id', 50)->nullable(false)->index();
                $table->string('status', 5)->nullable();
                $table->tinyInteger('status_factor');
                $table->date('buss_date')->nullable()->index();
                $table->date('tran_date')->nullable()->index();
                $table->date('value_date')->nullable()->index();
                $table->date('avail_date')->nullable()->index();
                $table->string('bank_acc_id', 50)->nullable()->index();
                $table->string('payee_bank_info', 50)->nullable();
                $table->string('cheque_no', 50)->nullable();
                $table->integer('client_acc_id')->unsigned()->nullable()->index();
                $table->string('ccy', 10)->nullable()->index();
                $table->decimal('amount_in', 22, 6)->nullable();
                $table->decimal('amount_out', 22, 6)->nullable();
                $table->decimal('amount', 22, 6)->nullable();
                $table->decimal('orig_amount', 22, 6)->nullable();
                $table->string('remark', 255)->nullable()->index();
                $table->string('gl_mapping_item_id', 50)->nullable()->index();
                $table->string('create_user', 20)->nullable();
                $table->datetime('create_time')->nullable();
                $table->string('confirm_user', 20)->nullable();
                $table->datetime('confirm_time')->nullable();
                $table->string('req_cancel_user', 20)->nullable();
                $table->datetime('req_cancel_time')->nullable();
                $table->string('cancel_user', 20)->nullable();
                $table->datetime('cancel_time')->nullable();
                $table->string('auto_gen_type', 20)->nullable();
                $table->string('auto_gen_tran_id', 50)->nullable();
                $table->string('same_day_cancel_flag', 5)->nullable();
                $table->string('back_date_flag', 5)->nullable();
                $table->string('cancelled', 5)->nullable();
                $table->string('other_name', 50)->nullable();
                $table->string('payee_name', 50)->nullable();
                $table->string('bank_code', 50)->nullable();
                $table->string('product_id', 20)->nullable()->index();
                $table->string('input_channel', 50)->nullable();
                $table->string('client_acc_name', 50)->nullable();
                $table->string('create_user_name', 50)->nullable();
                $table->string('confirm_user_name', 50)->nullable();
                $table->string('acct_code_map_item', 50)->nullable();
                $table->decimal('avail_bal', 22, 6)->nullable();
                $table->integer('client_code')->unsigned()->nullable();
                $table->timestamps();
                $table->unique(['tran_type','tran_sub_type','tran_id'],'unique1');
            });

            Schema::table($table_name, function (Blueprint $table) use($table_name) {
                DB::statement('ALTER TABLE '.$table_name.' MODIFY COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP');
                DB::statement('ALTER TABLE '.$table_name.' ADD INDEX created_at_index (`created_at`)');
                DB::statement('ALTER TABLE '.$table_name.' MODIFY COLUMN updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP');
                DB::statement('ALTER TABLE '.$table_name.' ADD INDEX updated_at_index (`updated_at`)');
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
        // Schema::dropIfExists('client_fund_in_out_listing_csv01');
    }
}
