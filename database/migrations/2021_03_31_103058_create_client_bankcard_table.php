<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientBankcardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_bankcard';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false);
                $table->string('type',100)->nullable();
                $table->string('lcid',100)->nullable(false);
                $table->string('bank_name',100)->nullable(false);
                $table->string('bank_code',100)->nullable(false);
                $table->string('currency',100)->nullable();
                $table->string('account_no',100)->nullable(false)->unique();
                $table->string('bankcard_face',100)->nullable();
                $table->string('issued_by',100)->nullable();
                $table->string('status',100)->nullable(false)->default('unaudited');
                $table->text('remark')->nullable(false);
                $table->integer('count_of_audits')->nullable(false)->default('0');
                $table->string('previewing_by',50)->nullable();
                $table->datetime('closed_at')->nullable();
                $table->timestamps();
            });

            Schema::table($table_name, function (Blueprint $table) use($table_name) {
                DB::statement('ALTER TABLE '.$table_name.' ADD COLUMN bankcard_blob LONGBLOB NULL');
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
        // Schema::dropIfExists('client_bankcard');
    }
}
