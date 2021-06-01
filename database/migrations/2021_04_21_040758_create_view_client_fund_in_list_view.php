<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewClientFundInListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_client_fund_in_list");
        $sql=<<<SQL
CREATE VIEW `view_client_fund_in_list` AS
select cdp.uuid, caa.account_no, deposit_amount as amount, deposit_bank as bank, deposit_method as method, cdp.status, transfer_time, timezone 
from client_deposit_proof cdp
left join client_ayers_account caa on(cdp.uuid=caa.uuid and substring(caa.account_no,-2,2)='13')
union
select uuid, account_no, amount, bank, method, status, transfer_time, timezone from client_fund_in_requests
union
select uuid, account_in as account_no, amount, 'cyss' as bank, 'internal' as method, status, null as transfer_time, null as timezone from client_fund_internal_transfer_requests
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
        DB::statement("DROP VIEW IF EXISTS view_client_fund_in_list");
    }
}
