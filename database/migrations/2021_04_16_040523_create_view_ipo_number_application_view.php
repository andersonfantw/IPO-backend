<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewIpoNumberApplicationView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//         DB::statement("DROP VIEW IF EXISTS view_ipo_number_application");
//         $sql=<<<SQL
// CREATE VIEW `view_ipo_number_application` AS
// select vis.client_acc_id, count(*) as number_application
// from view_ipo_subscription vis
// left join (
//     select client_acc_id, product_id from view_ipo_refund vir
//     union
//     select client_acc_id, product_id from a_client_trade_journal_w_chrg_details_csv05 a05
// ) as t on(vis.client_acc_id=t.client_acc_id and vis.product_id=t.product_id)
// where t.product_id is null
// group by t.client_acc_id;
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
        DB::statement("DROP VIEW IF EXISTS view_ipo_number_application");
    }
}
