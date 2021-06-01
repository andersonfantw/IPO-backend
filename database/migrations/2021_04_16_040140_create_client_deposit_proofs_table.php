<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDepositProofsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_deposit_proof';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false);
                $table->string('image', 100)->nullable();
                $table->string('deposit_account', 100)->nullable(false);
                $table->decimal('deposit_amount', 22, 6)->nullable(false);
                $table->string('deposit_bank', 100)->nullable(false);
                $table->string('deposit_method', 50)->nullable(false);
                $table->string('other_deposit_method', 100)->nullable(false);
                $table->string('status', 100)->nullable()->default('pending');
                $table->text('remark')->nullable();
                $table->dateTime('transfer_time')->nullable();
                $table->integer('timezone')->nullable();
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
        // Schema::dropIfExists('client_deposit_proof');
    }
}
