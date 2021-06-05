<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'account_reports';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->foreignId('account_report_sending_summary_id')->constrained('account_report_sending_summary');
                $table->integer('client_acc_id')->nullable(false);
                // $table->string('status',50)->nullable(false);
                $table->datetime('report_queue_time')->nullable();
                $table->datetime('make_report_time')->nullable();
                $table->string('make_report_status',50)->nullable();
                $table->datetime('sending_queue_time')->nullable();
                $table->datetime('sending_time')->nullable();
                $table->string('sending_status',50)->nullable();
                $table->string('issued_by',50)->nullable();
                $table->text('remark')->nullable();
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
        // Schema::dropIfExists('account_reports');
    }
}
