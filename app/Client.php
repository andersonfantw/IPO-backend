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
    ];
    public function clientHKIDCard()
    {
        return $this->hasOne('App\ClientHKIDCard', 'uuid', 'uuid');
    }
    public function clientDepositProof()
    {
        return $this->hasOne('App\ClientDepositProof', 'uuid', 'uuid');
    }
    public function clientAddressProof()
    {
        return $this->hasOne('App\ClientAddressProof', 'uuid', 'uuid');
    }
    public function clientCNIDCard()
    {
        return $this->hasOne('App\ClientCNIDCard', 'uuid', 'uuid');
    }
    public function IDCard()
    {
        return $this->morphTo(__FUNCTION__, 'idcard_type', 'uuid', 'uuid');
    }
    public function clientBankCard()
    {
        return $this->hasOne('App\ClientBankCard', 'uuid', 'uuid');
    }
    public function clientWorkingStatus()
    {
        return $this->hasOne('App\ClientWorkingStatus', 'uuid', 'uuid');
    }
    public function clientFinancialStatus()
    {
        return $this->hasOne('App\ClientFinancialStatus', 'uuid', 'uuid');
    }
    public function clientInvestmentExperience()
    {
        return $this->hasOne('App\ClientInvestmentExperience', 'uuid', 'uuid');
    }
    public function clientInvestmentOrientation()
    {
        return $this->hasMany('App\ClientInvestmentOrientation', 'uuid', 'uuid')->orderBy('id', 'asc');
    }
    public function clientEvaluationResults()
    {
        return $this->hasOne('App\ClientEvaluationResults', 'uuid', 'uuid');
    }
    public function clientSignature()
    {
        return $this->hasOne('App\ClientSignature', 'uuid', 'uuid');
    }
    public function clientBusinessType()
    {
        return $this->hasOne('App\ClientBusinessType', 'uuid', 'uuid');
    }
}
