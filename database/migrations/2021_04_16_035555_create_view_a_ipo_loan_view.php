<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewAIpoLoanView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_a_ipo_loan");
        $sql=<<<SQL
CREATE VIEW `view_a_ipo_loan` AS
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
        SUBSTRING_INDEX(SUBSTRING_INDEX(a_client_fund_in_out_listing_csv01.remark,
                        ' ',
                        -(5)),
                ' ',
                1) AS product_id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(a_client_fund_in_out_listing_csv01.remark,
                        ' ',
                        -(2)),
                ' ',
                1) AS qty,
        0 AS alloted,
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
        ((a_client_fund_in_out_listing_csv01.gl_mapping_item_id = 'OTH:IPOLoan')
            AND (UPPER(SUBSTR(a_client_fund_in_out_listing_csv01.remark,
                    1,
                    9)) = 'IPO LOAN ')
            AND (LENGTH(a_client_fund_in_out_listing_csv01.remark) < 50));
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
        DB::statement("DROP VIEW IF EXISTS view_a_ipo_loan");
    }
}
