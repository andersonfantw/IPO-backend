<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientEvaluationResults extends Model
{
    protected $table = 'client_evaluation_results';
    protected $fillable = [
        'uuid',
        'investor_characteristics',
        'agree',
        'status',
        'remark',
        'count_of_audits',
    ];
}
