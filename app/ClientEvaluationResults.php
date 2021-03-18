<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientEvaluationResults extends Model
{
    protected $table = 'client_evaluation_results';
    protected $fillable = [
        'uuid',
        'score',
        'investor_characteristics',
        'risk_tolerance',
        'agree',
        'status',
        'remark',
        'count_of_audits',
    ];
}
