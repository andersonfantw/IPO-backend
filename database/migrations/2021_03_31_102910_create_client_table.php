<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false)->unique();
                $table->string('introducer_uuid',100)->nullable()->index();
                $table->string('type',100)->nullable()->index();
                $table->string('email',100)->unique();
                $table->string('country_code',100)->nullable(false);
                $table->string('mobile',100)->nullable(false)->index();
                $table->string('tel',100)->nullable();
                $table->string('fax',100)->nullable();
                $table->string('nationality',100)->nullable(false);
                $table->integer('progress')->nullable(false);
                $table->string('education_level',100)->nullable();
                $table->string('idcard_type',100)->nullable(false);
                $table->json('selected_flow',100)->nullable();
                $table->string('status',100)->nullable(false)->default('unaudited');
                $table->text('remark',100)->nullable();
                $table->integer('count_of_audits')->nullable(false)->default('0');
                $table->dateTime('closed_at')->nullable(false);
                $table->timestamps();
                $table->unique(['country_code','mobile']);
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
        // Schema::dropIfExists('client');
    }
}
