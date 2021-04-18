<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientInvestmentOrientation extends Model
{
    protected $table = 'client_investment_orientation';
    protected $fillable = [
        'uuid',
        'question_text',
        'answer',
    ];
}
