<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ViewClient extends Model
{
    use Notifiable;

    protected $table = 'view_client';
    protected $primaryKey = 'account_no';
    protected $fillable = ['remember_token'];

    public function SystemBadgePill()
    {
        return $this->hasMany('App\Models\SystemBadgePill','uuid','uuid');
    }

    public function TempIpoSummary()
    {
        return $this->hasMany('App\Models\TempIpoSummary','client_acc_id','account_no');
    }

    public function A01()
    {
        return $this->hasMany('App\Models\A01','client_acc_id','account_no');
    }

    public function A05()
    {
        return $this->hasMany('App\Models\A05','client_acc_id','account_no');
    }

    public function A06()
    {
        return $this->hasMany('App\Models\A06','client_acc_id','account_no');
    }

    public function A07_13()
    {
        return $this->hasMany('App\Models\A07','client_acc_id','account_no');
    }

    public function A07_08()
    {
        return $this->hasMany('App\Models\A07','client_acc_id','cash_account_no');
    }

    public function ViewIpoCumulativeIncome()
    {
        return $this->hasOne('App\Models\ViewIpoCumulativeIncome','client_acc_id','account_no');
    }
    public function ViewIpoNumberApplication()
    {
        return $this->hasOne('App\Models\ViewIpoNumberApplication','client_acc_id','account_no');
    }
    public function ViewIpoCumulativeNetAsset()
    {
        return $this->hasOne('App\Models\ViewIpoCumulativeNetAsset','account_no','account_no');
    }

    public function ViewAIpoFee()
    {
        return $this->hasMany('App\Models\ViewAIpoFee','client_acc_id','account_no');
    }

    public function ViewAIpoRefund()
    {
        return $this->hasMany('App\Models\ViewAIpoRefund','client_acc_id','account_no');
    }

    public function ViewAIpoSubscription()
    {
        return $this->hasMany('App\Models\ViewAIpoSubscription','client_acc_id','account_no');
    }

    public function ClientDepositProof()
    {
        return $this->hasMany('App\Models\ClientDepositProof','uuid','uuid');
    }

    public function ClientAyersAccount()
    {
        return $this->hasMany('App\Models\ClientAyersAccount','uuid','uuid');
    }

    public function ClientFundInRequest()
    {
        return $this->hasMany('App\Models\ClientFundInRequest','uuid','uuid');
    }

    public function ClientFundInternalTransferRequest()
    {
        return $this->hasMany('App\Models\ClientFundInternalTransferRequest','uuid','uuid');
    }

    public function ClientHkFundOutRequest()
    {
        return $this->hasMany('App\Models\ClientHkFundOutRequest','uuid','uuid');
    }

    public function ClientOverseasFundOutRequest()
    {
        return $this->hasMany('App\Models\ClientOverseasFundOutRequest','uuid','uuid');
    }

    public function ClientCreditCardsFundOutRequest()
    {
        return $this->hasMany('App\Models\ClientCreditCardsFundOutRequest','uuid','uuid');
    }

    public function ViewClientFundInList()
    {
        return $this->hasMany('App\Models\ViewClientFundInList','uuid','uuid');
    }

    public function ViewClientFundOutList()
    {
        return $this->hasMany('App\Models\ViewClientFundOutList','uuid','uuid');
    }

    public function ClientCreditCard()
    {
        return $this->hasMany('App\Models\ClientCreditCard','uuid','uuid');
    }

    public function ClientBankcard()
    {
        return $this->hasMany('App\Models\ClientBankcard','uuid','uuid');
    }
}
