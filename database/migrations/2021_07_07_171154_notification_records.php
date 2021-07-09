<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NotificationRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'notification_records';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->integer('client_acc_id')->nullable(false)->index();
                $table->string('name',50)->nullable(false);
                $table->string('contact')->nullable(false);
                $table->string('status',100)->nullable(false);
                $table->dateTime('queue_time')->nullable(false);
                $table->dateTime('sending_time')->nullable(false);
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
        // Schema::dropIfExists('notification_records');
    }
}
