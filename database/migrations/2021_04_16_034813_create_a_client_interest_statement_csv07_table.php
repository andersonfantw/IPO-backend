<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAClientInterestStatementCsv07Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'a_client_interest_statement_csv07';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->bigIncrements('sid');
                $table->string('rank', 20)->nullable();
                $table->integer('client_acc_id')->unsigned()->nullable(false)->index();
                $table->string('name', 100)->nullable();
                $table->string('ccy', 10)->nullable();
                $table->date('dayend_date')->nullable();
                $table->decimal('t0_amt', 22, 6)->nullable();
                $table->decimal('interest_rate', 22, 6)->nullable();
                $table->decimal('total_debit_interest', 22, 6)->nullable();
                $table->decimal('credit_interest', 22, 6)->nullable();
                $table->decimal('all_adj_interest', 22, 6)->nullable();
                $table->decimal('total_interest', 22, 6)->nullable();
                $table->decimal('posted_interest', 22, 6)->nullable();
                $table->decimal('unposted_interest', 22, 6)->nullable();
                $table->decimal('before_post_accrued', 22, 6)->nullable();
                $table->decimal('credit_interest_rate', 22, 6)->nullable();
                $table->decimal('debit_interest_rate', 22, 6)->nullable();
                $table->decimal('margin_call_interest_rate', 22, 6)->nullable();
                $table->decimal('debit_interest', 22, 6)->nullable();
                $table->decimal('margin_call_interest', 22, 6)->nullable();
                $table->decimal('dayend_credit_interest_rate', 22, 6)->nullable();
                $table->decimal('dayend_debit_interest_rate', 22, 6)->nullable();
                $table->decimal('dayend_margin_call_interest_rate', 22, 6)->nullable();
                $table->decimal('dayend_debit_interest_val', 22, 6)->nullable();
                $table->decimal('dayend_margin_call_val', 22, 6)->nullable();
                $table->decimal('dayend_marginable_val', 22, 6)->nullable();
                $table->timestamps();
                $table->unique(['client_acc_id','dayend_date','ccy'],'unique1');
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
        // Schema::dropIfExists('a_interest_statement_csv07');
    }
}
