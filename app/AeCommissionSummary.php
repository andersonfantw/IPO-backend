<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AeCommissionSummary extends Model
{
    protected $table = 'ae_commission_summary';
    protected $fillable = ['buss_date','ae_uuid','ae_codes','pay_date','issued_by','cate','application_fee_correction','bonus_application_correction','application_cost_correction','ae_application_cost_correction','transaction_number_correction','content'];
}
