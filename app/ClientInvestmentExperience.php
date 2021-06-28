<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientInvestmentExperience extends Model
{
    protected $table = 'client_investment_experience';
    protected $fillable = [
        'uuid',
        'investment_objective',
        'other_investment_objective',
        'stock',
        'derivative_warrants',
        'cbbc',
        'futures_and_options',
        'bonds_funds',
        'other_investment_experience',
        'status',
        'remark',
        'count_of_audits',
    ];
}
