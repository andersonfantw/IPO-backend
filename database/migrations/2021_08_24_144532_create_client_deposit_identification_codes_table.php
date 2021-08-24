<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDepositIdentificationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_deposit_identification_codes';
        if (Schema::hasTable($table_name)) {
            echo "$table_name table already exist!\n";
        } else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->string('uuid', 100);
                $table->string('identification_code', 10);
                $table->timestamps();
                $table->unique(['uuid']);
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
        // Schema::dropIfExists('client_deposit_identification_codes');
    }
}
