<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCysislProductInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'cysisl_product_info';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->bigIncrements('sid');
                $table->string('product_code', 10)->nullable(false)->index()->unique();
                $table->string('exchange_code', 10)->nullable();
                $table->string('short_name', 100)->nullable();
                $table->string('eng_name', 100)->nullable();
                $table->string('big5_name', 100)->nullable();
                $table->string('ccy', 10)->nullable();
                $table->decimal('nominal', 22, 6)->nullable();
                $table->string('status', 10)->nullable();
                $table->integer('lot_size')->nullable();
                $table->string('market_code', 20)->nullable();
                $table->string('instrument_type', 20)->nullable();
                $table->string('isin', 50)->nullable();
                $table->string('stamp', 10)->nullable();
                $table->string('ccass', 10)->nullable();
                $table->date('listing_date')->nullable();
                $table->date('warrant_expiry_date')->nullable();
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
        Schema::dropIfExists('cysisl_product_indo');
    }
}
