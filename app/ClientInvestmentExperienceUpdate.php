<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientInvestmentExperienceUpdate extends Model
{
    protected $table = 'client_investment_experience_updates';
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
        'issued_by',
        'previewing_by',
    ];

    public function Client()
    {
        return $this->belongsTo('App\Client', 'uuid', 'uuid');
    }
}
