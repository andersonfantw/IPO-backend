<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewClientView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_client");
        $sql=<<<SQL
CREATE VIEW `view_client` AS
    SELECT
        `caa`.`account_no` AS `account_no`,
        `vc`.`mobile` AS `mobile`,
        `c`.`nationality` AS `nationality`,
        `vc`.`hash_code` AS `password`,
        `vc`.`remember_token` AS `remember_token`,
        `caa`.`uuid` AS `uuid`
    FROM
        ((`client` `c`
        JOIN `client_ayers_account` `caa` ON ((`c`.`uuid` = `caa`.`uuid`)))
        JOIN `verification_code` `vc` ON ((`vc`.`mobile` = `c`.`mobile`)))
    WHERE
        (`caa`.`type` = '全權委託賬戶');
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
        DB::statement("DROP VIEW IF EXISTS view_client");
    }
}
