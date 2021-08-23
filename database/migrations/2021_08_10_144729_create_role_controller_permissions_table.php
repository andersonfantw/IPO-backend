<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleControllerPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'role_controller_permissions';
        if (Schema::hasTable($table_name)) {
            echo "$table_name table already exist!\n";
        } else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->integer('role_id');
                $table->integer('controller_id');
                $table->integer('permission_id');
                $table->timestamps();
                $table->unique(['role_id', 'controller_id', 'permission_id'], 'role_id_controller_id_permission_id');
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
        // Schema::dropIfExists('role_controller_permissions');
    }
}
