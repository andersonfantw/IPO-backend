<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpUpdateA01ProductId extends Migration
{
    /**
     * 8萬1千筆資料 144秒
     * 全有product_id下執行 5.5秒
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_update_a01_product_id");
        $sql=<<<SQL
        CREATE PROCEDURE `sp_update_a01_product_id`()
        BEGIN
            -- update a_client_fund_in_out_listing_csv01
            -- set product_id=SUBSTRING_INDEX(SUBSTRING_INDEX(remark,' ',-5),' ',1)
            -- where gl_mapping_item_id = 'OTH:IPOSubscription' and product_id is null;

            -- update a_client_fund_in_out_listing_csv01
            -- set product_id=SUBSTRING_INDEX(SUBSTRING_INDEX(remark,' ',-5),' ',1)
            -- where (gl_mapping_item_id = 'OTH:IPOLoan')
            --             AND (UPPER(SUBSTR(remark,1,9)) = 'IPO LOAN ')
            --             AND (LENGTH(remark) < 50)
            --             and product_id is null;

            -- update a_client_fund_in_out_listing_csv01
            -- set product_id=SUBSTRING_INDEX(SUBSTRING_INDEX(remark,' ',-5),' ',1)
            -- where gl_mapping_item_id = 'OTH:IPOFee' and product_id is null;

            -- update a_client_fund_in_out_listing_csv01
            -- set product_id=SUBSTRING_INDEX(SUBSTRING_INDEX(remark,' ',-7),' ',1)
            -- where gl_mapping_item_id = 'OTH:IPOInterest' and product_id is null;

            -- update a_client_fund_in_out_listing_csv01
            -- set product_id=SUBSTRING_INDEX(SUBSTRING_INDEX(remark,' ',-7),' ',1)
            -- where (gl_mapping_item_id = 'OTH:IPOLoan')
            --             AND (UPPER(SUBSTR(remark,1,16)) = 'IPO LOAN RETURN ')
            --             and product_id is null;

            -- update a_client_fund_in_out_listing_csv01
            -- set product_id=SUBSTRING_INDEX(SUBSTRING_INDEX(remark,' ',-7),' ',1)
            -- where gl_mapping_item_id = 'OTH:IPORefund' and product_id is null;

            -- update a_client_fund_in_out_listing_csv01
            -- set product_id=SUBSTRING_INDEX(SUBSTRING_INDEX(remark,' ',-5),' ',1)
            -- where gl_mapping_item_id='OTH:Acct1' and upper(substr(remark,1,8))='IPO LOAN';
            update a_client_fund_in_out_listing_csv01
            set product_id=concat(SUBSTRING_INDEX(SUBSTRING_INDEX(remark,':HK',1),' ',-1),':HK')
            where (gl_mapping_item_id in ('OTH:IPOFee','OTH:IPOInterest','OTH:IPOLoan','OTH:IPOSubscription','OTH:IPORefund')) 
				or (gl_mapping_item_id='OTH:Acct1' and upper(substr(remark,1,8))='IPO LOAN');
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
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_update_a01_product_id");
    }
}
