<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleFunctionPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'role_function_permissions';
        if (Schema::hasTable($table_name)) {
            echo "$table_name table already exist!\n";
        } else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id()->primary();
                $table->integer('role_id');
                $table->integer('function_id');
                $table->integer('permission_id');
                $table->timestamps();
                $table->unique(['role_id', 'function_id', 'permission_id']);
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
        // Schema::dropIfExists('role_function_permissions');
    }
}
