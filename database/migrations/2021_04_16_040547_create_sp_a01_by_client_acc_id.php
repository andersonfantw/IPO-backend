<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpA01ByClientAccId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_a01_by_client_acc_id");
        $sql=<<<SQL
CREATE PROCEDURE `sp_a01_by_client_acc_id`(val char(10))
BEGIN
select tmp.*, a06.product_name,
	case subscription+ipo_loan+ipo_fee+ipo_refund+ipo_interest+ipo_loan_return+ipo_sell
    when 0 then tmp.amount else subscription+ipo_loan+ipo_fee+ipo_refund+ipo_interest+ipo_loan_return+ipo_sell end as 'amount'
from (
		select vis.tran_id, vis.tran_type, vis.tran_sub_type, vis.client_acc_id, vis.client_type, vis.buss_date, vis.product_id, vis.qty, vis.price, vis.amount, vis.create_time, vis.remark,
			ifnull(a05.avg_price,0) as 'avg_price', ifnull(a05.qty,0) as 'alloted', ifnull(a05.gross_amt,0) as 'gross_amt',
			cast('subscription' as char(50)) as method,
			ifnull(vis.buss_date,'') as 'subscription_date',
			ifnull(vis.amount,0) as 'subscription',
			ifnull(vil.buss_date,'') as 'ipo_loan_date',
			ifnull(vil.amount,0) as 'ipo_loan',
			ifnull(vif.buss_date,'') as 'ipo_fee_date',
			ifnull(vif.amount,0) as 'ipo_fee',
			ifnull(vir.buss_date,'') as 'ipo_refund_date',
			ifnull(vir.amount,0) as 'ipo_refund',
			ifnull(vii.buss_date,'') as 'ipo_interest_date',
			ifnull(vii.amount,0) as 'ipo_interest',
			ifnull(vilr.buss_date,'') as 'ipo_loan_return_date',
			ifnull(vilr.amount,0) as 'ipo_loan_return',
			ifnull(a05.buss_date,'') as 'ipo_sell_date',
			ifnull(a05.net_amt,0) as 'ipo_sell'
		from view_a_ipo_subscription vis
		left join view_a_ipo_loan vil on(vis.product_id=vil.product_id and vis.client_acc_id=vil.client_acc_id)
		left join view_a_ipo_fee vif on(vis.product_id=vif.product_id and vis.client_acc_id=vif.client_acc_id)
		left join view_a_ipo_refund vir on(vis.product_id=vir.product_id and vis.client_acc_id=vir.client_acc_id)
		left join view_a_ipo_interest vii on(vis.product_id=vii.product_id and vis.client_acc_id=vii.client_acc_id)
		left join view_a_ipo_loan_return vilr on(vis.product_id=vilr.product_id and vis.client_acc_id=vilr.client_acc_id)
		left join a_client_trade_journal_w_chrg_details_csv05 a05 on(vis.product_id=a05.product_id and vis.client_acc_id=a05.client_acc_id)
		where vis.client_acc_id=val
	union
    select tran_id, tran_type, tran_sub_type, client_acc_id, client_type, buss_date, product_id, qty, price, amount, create_time, remark,
		0 as 'avg_price', 0 as 'alloted', 0 as 'gross_amt',
		'accrued_interest_debit_cashdvp' as method,
		'' as 'subscription_date',
		0 as 'subscription',
        '' as 'ipo_loan_date',
		0 as 'ipo_loan',
        '' as 'ipo_fee_date',
		0 as 'ipo_fee',
        '' as 'ipo_refund_date',
		0 as 'ipo_refund',
        '' as 'ipo_interest_date',
		0 as 'ipo_interest',
        '' as 'ipo_loan_return_date',
		0 as 'ipo_loan_return',
        '' as 'ipo_sell_date',
        0 as 'ipo_sell'
        from view_a_accrued_interest_debit_cashdvp where client_acc_id=val
	union
    select tran_id, tran_type, tran_sub_type, client_acc_id, client_type, buss_date, product_id, qty, price, amount, create_time, remark,
		0 as 'avg_price', 0 as 'alloted', 0 as 'gross_amt',
		'acct1' as method,
		'' as 'subscription_date',
		0 as 'subscription',
        '' as 'ipo_loan_date',
		0 as 'ipo_loan',
        '' as 'ipo_fee_date',
		0 as 'ipo_fee',
        '' as 'ipo_refund_date',
		0 as 'ipo_refund',
        '' as 'ipo_interest_date',
		0 as 'ipo_interest',
        '' as 'ipo_loan_return_date',
		0 as 'ipo_loan_return',
        '' as 'ipo_sell_date',
        0 as 'ipo_sell'
        from view_a_acct1 where client_acc_id=val
) as tmp
left join a_ipo_subscription_detail_listing_csv06 a06 on (tmp.product_id=a06.product_id and tmp.client_acc_id=a06.client_acc_id)
order by tmp.create_time desc,tran_id desc;
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
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_a01_by_client_acc_id");
    }
}
