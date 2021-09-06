<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCNIDCardUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_cn_idcard_updates';
        if (Schema::hasTable($table_name)) {
            echo $table_name . " table already exist!\n";
        } else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->timestamps();
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
        // Schema::dropIfExists('client_c_n_i_d_card_updates');
    }
}
