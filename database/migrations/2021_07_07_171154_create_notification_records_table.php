<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationRecordsTable extends Migration
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
                $table->unsignedBigInteger('notification_group_id')->nullable()->index();
                $table->string('route',20)->nullable();
                $table->string('notification_template_id',50)->nullable();
                $table->integer('client_id')->nullable()->index();
                $table->string('name',50)->nullable();
                $table->string('phone',20)->nullable()->index();
                $table->string('email',100)->nullable()->index();
                $table->string('title')->nullable();
                $table->text('content')->nullable(false);
                $table->string('status',100)->nullable();
                $table->string('remark')->nullable(false);
                $table->dateTime('queue_time')->nullable();
                $table->dateTime('sending_time')->nullable();
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
        // Schema::dropIfExists('notification_records');
    }
}
