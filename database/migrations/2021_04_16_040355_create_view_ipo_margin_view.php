<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewIpoMarginView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_ipo_margin");
        $sql=<<<SQL
CREATE VIEW `view_ipo_margin` AS
    SELECT 
        `a_client_fund_in_out_listing_csv01`.`client_acc_id` AS `client_acc_id`,
        IF((SUM(`a_client_fund_in_out_listing_csv01`.`amount`) > 0),
            SUM(`a_client_fund_in_out_listing_csv01`.`amount`),
            0) AS `margin_amt`
    FROM
        `a_client_fund_in_out_listing_csv01`
    WHERE
        (`a_client_fund_in_out_listing_csv01`.`gl_mapping_item_id` = 'OTH:IPOLoan')
    GROUP BY `a_client_fund_in_out_listing_csv01`.`client_acc_id`;
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
        DB::statement("DROP VIEW IF EXISTS view_ipo_margin");
    }
}
