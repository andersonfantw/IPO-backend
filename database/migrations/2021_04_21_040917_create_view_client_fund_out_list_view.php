<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewClientFundOutListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_client_fund_out_list");
        $sql=<<<SQL
CREATE VIEW `view_client_fund_out_list` AS
select uuid, id, account_out, account_in, amount, 'cyss' as bank, 'internal' as method, '' as bank_address, '' as swift_code, status, previewing_by, updated_at from client_fund_internal_transfer_requests
union
select uuid, id, account_out, account_in, amount, bank, method, '' as bank_address, '' as swift_code, status, previewing_by, updated_at from client_hk_fund_out_requests
union
select uuid, id, account_out, account_in, amount, bank, 'oversea transfer' as method, bank_address, swift_code, status, previewing_by, updated_at from client_overseas_fund_out_requests
union
select uuid, id, account_out, account_in, amount, issued_by as bank, 'creditcard' as method, '', '', status, previewing_by, updated_at from client_credit_card_fund_out_requests
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
        DB::statement("DROP VIEW IF EXISTS view_client_fund_out_list");
    }
}
