<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewAIpoRefundView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_a_ipo_refund");
        $sql=<<<SQL
CREATE VIEW `view_a_ipo_refund` AS
    SELECT 
        `a_client_fund_in_out_listing_csv01`.`tran_id` AS `tran_id`,
        `a_client_fund_in_out_listing_csv01`.`tran_type` AS `tran_type`,
        `a_client_fund_in_out_listing_csv01`.`tran_sub_type` AS `tran_sub_type`,
        `a_client_fund_in_out_listing_csv01`.`client_acc_id` AS `client_acc_id`,
        (CASE
            WHEN (LENGTH(`a_client_fund_in_out_listing_csv01`.`client_acc_id`) = 7) THEN '拳頭打新'
            ELSE '拼一手'
        END) AS `client_type`,
        a_client_fund_in_out_listing_csv01.buss_date AS buss_date,
        a_client_fund_in_out_listing_csv01.amount AS amount,
        CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(a_client_fund_in_out_listing_csv01.remark,':HK',1),' ',-1),':HK') AS product_id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(a_client_fund_in_out_listing_csv01.remark,'Qty: ',-1),' ',1) AS qty,
        SUBSTRING_INDEX(SUBSTRING_INDEX(a_client_fund_in_out_listing_csv01.remark,
                        ' ',
                        -(2)),
                ' ',
                1) AS alloted,
        REPLACE(SUBSTRING_INDEX(a_client_fund_in_out_listing_csv01.remark,
                    ' ',
                    -(1)),
            '@',
            '') AS price,
        a_client_fund_in_out_listing_csv01.create_time AS `create_time`,
        a_client_fund_in_out_listing_csv01.remark AS remark
    FROM
        a_client_fund_in_out_listing_csv01
    WHERE
        (a_client_fund_in_out_listing_csv01.gl_mapping_item_id = 'OTH:IPORefund');
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
        DB::statement("DROP VIEW IF EXISTS view_a_ipo_refund");
    }
}
