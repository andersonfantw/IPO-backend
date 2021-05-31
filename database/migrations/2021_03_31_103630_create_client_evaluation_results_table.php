<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientEvaluationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_evaluation_results';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false)->unique();
                $table->string('investor_characteristics',100)->nullable();
                $table->tinyInteger('agree')->nullable(false);
                $table->string('status',100)->nullable(false)->default('unaudited');
                $table->text('remark')->nullable();
                $table->integer('count_of_audits')->nullable(false)->default('0');
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
        // Schema::dropIfExists('client_evaluation_results');
    }
}
