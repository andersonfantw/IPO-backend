<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAIpoSubscriptionDetailListingCsv06Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'a_ipo_subscription_detail_listing_csv06';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->bigIncrements('sid');
                $table->string('group_key', 20)->nullable();
                $table->string('product_id', 20)->nullable(false)->index();
                $table->string('product_name', 50)->nullable();
                $table->string('name', 20)->nullable();
                $table->decimal('p1', 22, 6)->nullable();
                $table->decimal('p2', 22, 6)->nullable();
                $table->decimal('p3', 22, 6)->nullable();
                $table->decimal('p4', 22, 6)->nullable();
                $table->decimal('p5', 22, 6)->nullable();
                $table->decimal('p6', 22, 6)->nullable();
                $table->datetime('start_time')->nullable();
                $table->datetime('close_time')->nullable();
                $table->datetime('margin_close_time')->nullable();
                $table->date('allot_date')->nullable();
                $table->decimal('allot_price', 22, 6)->nullable();
                $table->string('ae_code', 10)->nullable();
                $table->integer('clnId')->unsigned()->nullable()->index();
                $table->string('client_acc_name', 50)->nullable();
                $table->string('id', 50)->nullable();
                $table->integer('client_acc_id')->unsigned()->nullable(false)->index();
                $table->string('product_id1', 20)->nullable();
                $table->string('name1', 20)->nullable();
                $table->string('ccy', 10)->nullable();
                $table->decimal('allot_price1', 22, 6)->nullable();
                $table->string('app_posted', 5)->nullable();
                $table->string('issue_price_range', 50)->nullable();
                $table->decimal('amount', 22, 6)->nullable();
                $table->integer('qty')->nullable();
                $table->decimal('loan_ration', 22, 6)->nullable();
                $table->decimal('loan_amt', 22, 6)->nullable();
                $table->decimal('interest_rate', 22, 6)->nullable();
                $table->decimal('interest', 22, 6)->nullable();
                $table->decimal('charge', 22, 6)->nullable();
                $table->decimal('refund_amt', 22, 6)->nullable();
                $table->integer('actual_qty')->nullable();
                $table->string('remark', 255)->nullable();
                $table->datetime('create_time')->nullable();
                $table->string('create_user', 20)->nullable();
                $table->string('status', 50)->nullable();
                $table->decimal('actual_turnover', 22, 6)->nullable();
                $table->decimal('t0_amt', 22, 6)->nullable();
                $table->decimal('call_amt', 22, 6)->nullable();
                $table->string('ae_name', 50)->nullable();
                $table->decimal('liquidcap_cysisl', 22, 6)->nullable();
                $table->timestamps();
                $table->unique(['product_id','client_acc_id'],'unique1');
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
        // Schema::dropIfExists('a_ipo_subscription_detail_listing_csv06');
    }
}
