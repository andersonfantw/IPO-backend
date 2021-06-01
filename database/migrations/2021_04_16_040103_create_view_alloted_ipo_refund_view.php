<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewAllotedIpoRefundView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_alloted_ipo_refund");
        $sql=<<<SQL
CREATE VIEW `view_alloted_ipo_refund` AS
    SELECT 
        `a`.`client_acc_id` AS `client_acc_id`,
        `b`.`buss_date` AS `buss_date`,
        `a`.`product_id` AS `product_id`,
        `b`.`remark` AS `remark`,
        `b`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
        `b`.`amount` AS `amount`
    FROM
        (`a_client_trade_journal_w_chrg_details_csv05` `a`
        JOIN `a_client_fund_in_out_listing_csv01` `b` ON (((`a`.`client_acc_id` = `b`.`client_acc_id`)
            AND (`b`.`product_id` = `a`.`product_id`))))
    WHERE
        (`b`.`gl_mapping_item_id` = 'OTH:IPORefund');
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
        DB::statement("DROP VIEW IF EXISTS view_alloted_ipo_refund");
    }
}
