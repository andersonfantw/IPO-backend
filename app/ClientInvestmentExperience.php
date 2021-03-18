<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientInvestmentExperience extends Model
{
    protected $table = 'client_investment_experience';
    protected $fillable = [
        'uuid',
        'investment_objective',
        'stock',
        'derivative_warrants',
        'cbbc',
        'futures_and_options',
        'bonds_funds',
        'other_investment_experience',
        'intend_to_invest_in_derivatives',
        'status',
        'remark',
        'count_of_audits',
    ];
}
