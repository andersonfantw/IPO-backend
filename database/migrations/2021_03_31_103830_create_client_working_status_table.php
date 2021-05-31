<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientWorkingStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_working_status';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false)->unique();
                $table->string('working_status',100)->nullable(false);
                $table->string('company_name',100)->nullable();
                $table->string('company_tel')->nullable();
                $table->string('school_name',100)->nullable();
                $table->string('industry',100)->nullable();
                $table->string('name_card_face',100)->nullable();
                $table->string('status',100)->nullable(false);
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
        // Schema::dropIfExists('client_working_status');
    }
}
