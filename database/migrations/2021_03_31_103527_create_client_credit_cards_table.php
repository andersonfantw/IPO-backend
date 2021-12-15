<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateClientCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_credit_cards';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false);
                $table->string('card_no',100)->nullable(false)->unique();
                $table->string('owner_name',100)->nullable(false);
                $table->date('expiry_date')->nullable(false);
                $table->string('card_issuer',100)->nullable(false);
                $table->string('issued_by',100)->nullable();
                $table->string('status',100)->nullable(false)->index()->default('pending');
                $table->text('remark')->nullable();
                $table->integer('count_of_audits')->default('0');
                $table->string('previewing_by',50)->nullable()->index();
                $table->date('closed_at')->nullable()->index();
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
        // Schema::dropIfExists('client_credit_cards');
    }
}
