<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnknownDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'unknown_deposits';
        if (Schema::hasTable($table_name)) {
            echo "$table_name table already exist!\n";
        } else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->datetime('transaction_date');
                $table->date('value_date');
                $table->string('type');
                $table->string('summary');
                $table->string('remark')->nullable();
                $table->string('identification_code')->nullable();
                $table->double('amount_in');
                $table->double('balance');
                $table->string('voucher_no')->nullable();
                $table->string('account_no');
                $table->string('account_name');
                $table->string('trading_place')->nullable();
                $table->timestamps();
                $table->unique(['identification_code']);
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
        // Schema::dropIfExists('unknown_deposits');
    }
}
