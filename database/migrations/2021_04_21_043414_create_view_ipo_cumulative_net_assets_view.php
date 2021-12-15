<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewIpoCumulativeNetAssetsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//         DB::statement("DROP VIEW IF EXISTS view_ipo_cumulative_net_assets");
//         $sql=<<<SQL
// CREATE VIEW `view_ipo_cumulative_net_assets` AS
// select account_no, sum(amount) as amount from(
// select client_acc_id as account_no, cumulative_income as amount from view_ipo_cumulative_income
// union
// select account_no, sum(amount) as amount from view_client_fund_in_list group by account_no
// union
// select account_out as account_no, -(sum(amount)) as amount from view_client_fund_out_list group by account_out
// ) as t group by account_no
// SQL;
//         DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_ipo_cumulative_net_assets");
    }
}
