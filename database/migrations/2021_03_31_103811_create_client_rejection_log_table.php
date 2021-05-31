<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientRejectionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_rejection_log';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false);
                $table->string('rejected_section',100)->nullable(false);
                $table->text('remark')->nullable(false);
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
        // Schema::dropIfExists('client_rejection_log');
    }
}
