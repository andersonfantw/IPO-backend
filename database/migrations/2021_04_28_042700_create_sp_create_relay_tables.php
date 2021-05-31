<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpCreateRelayTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_create_relay_tables");
        $sql=<<<SQL
        CREATE PROCEDURE `sp_create_relay_tables`()
        BEGIN
            delete from `tt_ipo_cumulative_income` where client_acc_id>0;
            insert into `tt_ipo_cumulative_income` SELECT *, current_timestamp() as create_at FROM `view_ipo_cumulative_income` where client_acc_id>0;
            delete from `tt_ipo_cumulative_income_by_buss_date` where client_acc_id>0;
            insert into `tt_ipo_cumulative_income_by_buss_date` SELECT *, current_timestamp() as create_at FROM `view_ipo_cumulative_income_by_buss_date` where client_acc_id>0;
            -- delete from `tt_ipo_cumulative_net_assets` where account_no<>'';
            -- insert into `tt_ipo_cumulative_net_assets` SELECT *, current_timestamp() as create_at FROM `view_ipo_cumulative_net_assets` where account_no<>'';
            delete from `tt_ipo_number_application` where client_acc_id>0;
            insert into `tt_ipo_number_application` SELECT *, current_timestamp() as create_at FROM `view_ipo_number_application` where client_acc_id>0;
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
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_create_relay_tables");
    }
}
