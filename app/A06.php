<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\tableAssist;

class A06 extends Model
{
    use tableAssist;
    
    protected $table = 'a_ipo_subscription_detail_listing_csv06';
    protected $primaryKey = 'sid';
    protected $fillable = [
        'group_key',
        'product_id',
        'product_name',
        'name',
        'p1',
        'p2',
        'p3',
        'p4',
        'p5',
        'p6',
        'start_time',
        'close_time',
        'margin_close_time',
        'allot_date',
        'allot_price',
        'ae_code',
        'clnId',
        'client_acc_name',
        'id',
        'client_acc_id',
        'product_id1',
        'name1',
        'ccy',
        'allot_price1',
        'app_posted',
        'issue_price_range',
        'amount',
        'qty',
        'loan_ration',
        'loan_amt',
        'interest_rate',
        'interest',
        'charge',
        'refund_amt',
        'actual_qty',
        'remark',
        'create_time',
        'create_user',
        'status',
        'actual_turnover',
        't0_amt',
        'call_amt',
        'ae_name',
        'liquidcap_cysisl',
    ];

    public static function getTableColumns() {
        $instance = new static;
        return $instance->getConnection()->getSchemaBuilder()->getColumnListing($instance->getTable());
    }
}
