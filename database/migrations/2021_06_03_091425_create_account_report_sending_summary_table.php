<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountReportSendingSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'account_report_sending_summary';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->integer('ipo_activity_period_id')->nullable(false);
                $table->date('start_date')->nullable(false);
                $table->date('end_date')->nullable(false);
                $table->date('report_make_date')->nullable(false);
                $table->date('performance_fee_date')->nullable(false);
                $table->text('report')->nullable();
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
        // Schema::dropIfExists('account_report_sending_summary');
    }
}
