<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewAAcct1View extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_a_acct1");
        $sql=<<<SQL
CREATE VIEW `view_a_acct1` AS
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
        '' AS product_id,
        0 AS qty,
        0 AS alloted,
        0 AS price,
        a_client_fund_in_out_listing_csv01.create_time AS `create_time`,
        a_client_fund_in_out_listing_csv01.remark AS remark
    FROM
        a_client_fund_in_out_listing_csv01
    WHERE
        (a_client_fund_in_out_listing_csv01.gl_mapping_item_id = 'OTH:Acct1');
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
        DB::statement("DROP VIEW IF EXISTS view_a_acct1");
    }
}
