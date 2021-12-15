<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAClientListingCsv02Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'a_client_listing_csv02';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->bigIncrements('sid');
                $table->integer('client_id')->unsigned()->nullable(false)->index();
                $table->string('id_code', 50)->nullable();
                $table->string('name', 50)->nullable();
                $table->string('ae_code', 10)->nullable();
                $table->string('addr', 255)->nullable();
                $table->date('open_date')->nullable(false);
                $table->string('phone', 20)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('client_group_code', 50)->nullable();
                $table->timestamps();
                $table->unique(['client_id','open_date'],'unique1');
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
        // Schema::dropIfExists('a_client_listing_csv02');
    }
}
