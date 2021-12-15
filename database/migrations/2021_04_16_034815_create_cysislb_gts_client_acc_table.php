<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCysislbGtsClientAccTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'cysislb_gts_client_acc';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->bigIncrements('sid');
                $table->integer('client_acc_id')->nullable(false)->unsigned()->unique()->index();
                $table->string('name',100)->nullable(false);
                $table->string('ae_code', 10)->nullable();
                $table->string('acc_type', 10)->nullable();
                $table->string('status', 10)->nullable();
                $table->decimal('loan_limit', 22, 6)->nullable();
                $table->decimal('trading_limit', 22, 6)->nullable();
                $table->string('ors_investor_id',100)->nullable();
                $table->string('disallow_buy',100)->nullable();
                $table->string('disallow_sell',100)->nullable();
                $table->decimal('margin_ratio', 22, 6)->nullable()->default(0);
                $table->decimal('comm_rate', 22, 6)->nullable();
                $table->decimal('min_commission', 22, 6)->nullable();
                $table->string('email',100)->nullable();
                $table->string('phone',20)->nullable();
                $table->string('fax',20)->nullable();
                $table->string('remark',255)->nullable();
                $table->string('addr',255)->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('cysislb_gts_client_acc');
    }
}
