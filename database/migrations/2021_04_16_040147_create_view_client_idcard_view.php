<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewClientIdcardView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS view_client_idcard");
        $sql=<<<SQL
CREATE VIEW `view_client_idcard` AS
    SELECT 
        `client_hk_idcard`.`uuid` AS `uuid`,
        `client_hk_idcard`.`idcard_face` AS `idcard_face`,
        `client_hk_idcard`.`idcard_back` AS `idcard_back`,
        `client_hk_idcard`.`name_c` AS `name_c`,
        UPPER(`client_hk_idcard`.`name_en`) AS `name_en`,
        `client_hk_idcard`.`gender` AS `gender`,
        `client_hk_idcard`.`birthday` AS `birthday`,
        FLOOR(((TO_DAYS(CURDATE()) - TO_DAYS(`client_hk_idcard`.`birthday`)) / 365)) AS `age`,
        `client_hk_idcard`.`idcard_no` AS `idcard_no`,
        'IDHK' AS `passport_type`,
        `client_address_proof`.`address_text` AS `address_line1`,
        `client_hk_idcard`.`status` AS `status`,
        `client_hk_idcard`.`remark` AS `remark`,
        `client_hk_idcard`.`count_of_audits` AS `count_of_audits`
    FROM
        (`client_hk_idcard`
        JOIN `client_address_proof` ON ((`client_hk_idcard`.`uuid` = `client_address_proof`.`uuid`))) 
    UNION SELECT 
        `client_cn_idcard`.`uuid` AS `uuid`,
        `client_cn_idcard`.`idcard_face` AS `idcard_face`,
        `client_cn_idcard`.`idcard_back` AS `idcard_back`,
        `client_cn_idcard`.`name_c` AS `name_c`,
        UPPER(CONCAT(`client_cn_idcard`.`surname`,
                        ' ',
                        `client_cn_idcard`.`given_name`)) AS `UPPER(CONCAT(surname, " ", given_name))`,
        `client_cn_idcard`.`gender` AS `gender`,
        `client_cn_idcard`.`birthday` AS `birthday`,
        FLOOR(((TO_DAYS(CURDATE()) - TO_DAYS(`client_cn_idcard`.`birthday`)) / 365)) AS `age`,
        `client_cn_idcard`.`idcard_no` AS `idcard_no`,
        'IDCN' AS `passport_type`,
        `client_cn_idcard`.`idcard_address` AS `address_line1`,
        `client_cn_idcard`.`status` AS `status`,
        `client_cn_idcard`.`remark` AS `remark`,
        `client_cn_idcard`.`count_of_audits` AS `count_of_audits`
    FROM
        `client_cn_idcard`;
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
        DB::statement("DROP VIEW IF EXISTS view_client_idcard");
    }
}
