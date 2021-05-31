<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpCurrentLoan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_current_loan");
        $sql=<<<SQL
CREATE PROCEDURE `sp_current_loan`(val char(10))
BEGIN
	select (select sum(amount) from view_a_ipo_loan where client_acc_id=val) + (select sum(amount) from view_a_ipo_loan_return where client_acc_id=val) as amount;
END
SQL;
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_current_loan");
    }
}
