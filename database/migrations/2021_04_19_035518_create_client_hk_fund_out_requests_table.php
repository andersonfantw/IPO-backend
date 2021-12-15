<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateClientHkFundOutRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_hk_fund_out_requests';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false)->index();
                $table->string('account_out',20)->nullable(false)->index();
                $table->string('method',50)->nullable(false);
                $table->decimal('amount',22,6)->nullable(false);
                $table->string('bank',100)->nullable(false);
                $table->string('account_in',20)->nullable(false)->index();
                $table->string('status',50)->nullable(false)->default('pending');
                $table->string('previewing_by',50)->nullable();
                $table->string('issued_by',50)->nullable();
                $table->text('remark')->nullable();
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
        // Schema::dropIfExists('client_hk_fund_out_request');
    }
}
