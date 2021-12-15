<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewIpoCumulativeIncomeByBussDateView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_ipo_cumulative_income_by_buss_date");
        $sql=<<<SQL
CREATE VIEW `view_ipo_cumulative_income_by_buss_date` AS
    SELECT 
        `a`.`client_acc_id` AS `client_acc_id`,
        `a`.`buss_date` AS `buss_date`,
        SUM(`a`.`amount`) AS `cumulative_income`
    FROM
        (SELECT 
            `view_alloted_ipo_refund`.`client_acc_id` AS `client_acc_id`,
                `view_alloted_ipo_refund`.`buss_date` AS `buss_date`,
                `view_alloted_ipo_refund`.`product_id` AS `product_id`,
                `view_alloted_ipo_refund`.`remark` AS `remark`,
                `view_alloted_ipo_refund`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
                `view_alloted_ipo_refund`.`amount` AS `amount`
        FROM
            `view_alloted_ipo_refund` UNION SELECT 
            `view_alloted_ipo_subscription`.`client_acc_id` AS `client_acc_id`,
                `view_alloted_ipo_subscription`.`buss_date` AS `buss_date`,
                `view_alloted_ipo_subscription`.`product_id` AS `product_id`,
                `view_alloted_ipo_subscription`.`remark` AS `remark`,
                `view_alloted_ipo_subscription`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
                `view_alloted_ipo_subscription`.`amount` AS `amount`
        FROM
            `view_alloted_ipo_subscription` UNION SELECT 
            `view_in_refund_handling_fee_of_ipo`.`client_acc_id` AS `client_acc_id`,
                `view_in_refund_handling_fee_of_ipo`.`buss_date` AS `buss_date`,
                `view_in_refund_handling_fee_of_ipo`.`product_id` AS `product_id`,
                `view_in_refund_handling_fee_of_ipo`.`remark` AS `remark`,
                `view_in_refund_handling_fee_of_ipo`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
                `view_in_refund_handling_fee_of_ipo`.`amount` AS `amount`
        FROM
            `view_in_refund_handling_fee_of_ipo` UNION SELECT 
            `view_ipo_fee`.`client_acc_id` AS `client_acc_id`,
                `view_ipo_fee`.`buss_date` AS `buss_date`,
                `view_ipo_fee`.`product_id` AS `product_id`,
                `view_ipo_fee`.`remark` AS `remark`,
                `view_ipo_fee`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
                `view_ipo_fee`.`amount` AS `amount`
        FROM
            `view_ipo_fee` UNION SELECT 
            `view_ipo_interest`.`client_acc_id` AS `client_acc_id`,
                `view_ipo_interest`.`buss_date` AS `buss_date`,
                `view_ipo_interest`.`product_id` AS `product_id`,
                `view_ipo_interest`.`remark` AS `remark`,
                `view_ipo_interest`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
                `view_ipo_interest`.`amount` AS `amount`
        FROM
            `view_ipo_interest` UNION SELECT 
            `view_monthly_interest_paid`.`client_acc_id` AS `client_acc_id`,
                `view_monthly_interest_paid`.`buss_date` AS `buss_date`,
                `view_monthly_interest_paid`.`product_id` AS `product_id`,
                `view_monthly_interest_paid`.`remark` AS `remark`,
                `view_monthly_interest_paid`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
                `view_monthly_interest_paid`.`amount` AS `amount`
        FROM
            `view_monthly_interest_paid` UNION SELECT 
            `view_management_fee`.`client_acc_id` AS `client_acc_id`,
                `view_management_fee`.`buss_date` AS `buss_date`,
                `view_management_fee`.`product_id` AS `product_id`,
                `view_management_fee`.`remark` AS `remark`,
                `view_management_fee`.`gl_mapping_item_id` AS `gl_mapping_item_id`,
                `view_management_fee`.`amount` AS `amount`
        FROM
            `view_management_fee` UNION SELECT 
            `a_client_trade_journal_w_chrg_details_csv05`.`client_acc_id` AS `client_acc_id`,
                `a_client_trade_journal_w_chrg_details_csv05`.`buss_date` AS `buss_date`,
                `a_client_trade_journal_w_chrg_details_csv05`.`product_id` AS `product_id`,
                `a_client_trade_journal_w_chrg_details_csv05`.`product_id` AS `product_id`,
                `a_client_trade_journal_w_chrg_details_csv05`.`product_id` AS `product_id`,
                `a_client_trade_journal_w_chrg_details_csv05`.`net_amt` AS `net_amt`
        FROM
            `a_client_trade_journal_w_chrg_details_csv05` UNION SELECT 
            `a_client_trade_journal_w_chrg_details_csv05`.`client_acc_id` AS `client_acc_id`,
                `a_client_trade_journal_w_chrg_details_csv05`.`buss_date` AS `buss_date`,
                `a_client_trade_journal_w_chrg_details_csv05`.`product_id` AS `product_id`,
                'IPO Apply 09633:HK 9633' AS `IPO Apply 09633:HK 9633`,
                'OTH:IPOSubscription' AS `OTH:IPOSubscription`,
                -(4343.34) AS `amount`
        FROM
            `a_client_trade_journal_w_chrg_details_csv05`
        WHERE
            (`a_client_trade_journal_w_chrg_details_csv05`.`product_id` = '09633:HK')) `a`
    GROUP BY `a`.`client_acc_id` , `a`.`buss_date`;
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
        DB::statement("DROP VIEW IF EXISTS view_ipo_cumulative_income_by_buss_date");
    }
}
