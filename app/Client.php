<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    protected $fillable = [
        'uuid',
        'introducer_uuid',
        'email',
        'mobile',
        'tel',
        'fax',
        'nationality',
        'status',
        'progress',
        'education_level',
        'idcard_type',
        'status',
        'remark',
        'count_of_audits',
        'editable',
    ];

    public function SentEmailRecords()
    {
        return $this->hasMany('App\SentEmailRecord', 'uuid', 'uuid')->orderBy('created_at', 'desc');
    }

    public function EditableSteps()
    {
        return $this->hasMany('App\EditableSteps', 'uuid', 'uuid')->orderBy('step', 'asc');
    }

    public function ViewIntroducer()
    {
        return $this->hasOne('App\ViewIntroducer', 'uuid', 'introducer_uuid');
    }

    public function ViewClientScore()
    {
        return $this->hasMany('App\ViewClientScore', 'uuid', 'uuid');
    }

    public function ViewClientIDCard()
    {
        return $this->hasOne('App\ViewClientIDCard', 'uuid', 'uuid');
    }

    public function ViewClientQuestionnaire()
    {
        return $this->hasOne('App\ViewClientQuestionnaire', 'uuid', 'uuid');
    }

    public function ClientHKIDCard()
    {
        return $this->hasOne('App\ClientHKIDCard', 'uuid', 'uuid');
    }

    public function ClientDepositProof()
    {
        return $this->hasOne('App\ClientDepositProof', 'uuid', 'uuid');
    }

    public function ClientAddressProof()
    {
        return $this->hasOne('App\ClientAddressProof', 'uuid', 'uuid');
    }

    public function ClientCNIDCard()
    {
        return $this->hasOne('App\ClientCNIDCard', 'uuid', 'uuid');
    }

    public function IDCard()
    {
        return $this->morphTo(__FUNCTION__, 'idcard_type', 'uuid', 'uuid');
    }

    public function ClientBankCards()
    {
        return $this->hasMany('App\ClientBankCard', 'uuid', 'uuid');
    }

    public function ClientWorkingStatus()
    {
        return $this->hasOne('App\ClientWorkingStatus', 'uuid', 'uuid');
    }

    public function ClientFinancialStatus()
    {
        return $this->hasOne('App\ClientFinancialStatus', 'uuid', 'uuid');
    }

    public function ClientInvestmentExperience()
    {
        return $this->hasOne('App\ClientInvestmentExperience', 'uuid', 'uuid');
    }

    public function ClientInvestmentOrientation()
    {
        return $this->hasMany('App\ClientInvestmentOrientation', 'uuid', 'uuid')->orderBy('id', 'asc');
    }

    public function ClientEvaluationResults()
    {
        return $this->hasOne('App\ClientEvaluationResults', 'uuid', 'uuid');
    }

    public function ClientSignature()
    {
        return $this->hasOne('App\ClientSignature', 'uuid', 'uuid');
    }

    public function ClientBusinessType()
    {
        return $this->hasOne('App\ClientBusinessType', 'uuid', 'uuid');
    }

    public function AyersAccounts()
    {
        return $this->hasMany('App\ClientAyersAccount', 'uuid', 'uuid')->orderBy('account_no', 'asc');
    }
}
