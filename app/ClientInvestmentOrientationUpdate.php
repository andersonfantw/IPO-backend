<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientInvestmentOrientationUpdate extends Model
{
    protected $table = 'client_investment_orientation_updates';
    protected $fillable = [
        'uuid',
        'question_text',
        'answer',
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
