<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewIpoRefundView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_ipo_refund");
        $sql=<<<SQL
CREATE VIEW `view_ipo_refund` AS
    SELECT 
        `a_client_fund_in_out_listing_csv01`.`client_acc_id` AS `client_acc_id`,
        `a_client_fund_in_out_listing_csv01`.`buss_date` AS `buss_date`,
        `a_client_fund_in_out_listing_csv01`.`product_id` AS `product_id`,
        `a_client_fund_in_out_listing_csv01`.`remark` AS `remark`,
        `a_client_fund_in_out_listing_csv01`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
        `a_client_fund_in_out_listing_csv01`.`amount` AS `amount`
    FROM
        `a_client_fund_in_out_listing_csv01`
    WHERE
        (`a_client_fund_in_out_listing_csv01`.`gl_mapping_item_id` = 'OTH:IPORefund');
SQL;
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_ipo_refund");
    }
}
