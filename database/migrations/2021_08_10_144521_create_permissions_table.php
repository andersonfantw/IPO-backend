<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'permissions';
        if (Schema::hasTable($table_name)) {
            echo "$table_name table already exist!\n";
        } else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id()->primary();
                $table->string('name', 100);
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
        // Schema::dropIfExists('permissions');
    }
}
