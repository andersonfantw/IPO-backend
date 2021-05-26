<?php
namespace App\Traits;

use App\Client;
use App\ClientCNIDCard;
use App\ClientCreditCardFundOutRequest;
use App\ClientFundInRequest;
use App\ClientFundInternalTransferRequest;
use App\ClientHKFundOutRequest;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use App\ClientOverseasFundOutRequest;
use Illuminate\Database\Eloquent\Builder;

trait CountRecords
{
    public function countNewUnauditedClients1()
    {
        $NoOfNews = Client::whereHasMorph('IDCard', [
            ClientCNIDCard::class,
            ClientHKIDCard::class,
            ClientOtherIDCard::class,
        ], function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientBankCards', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->whereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'unaudited');
        })->where('status', 'unaudited')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewUnauditedClients2()
    {
        $NoOfNews = Client::whereHasMorph('IDCard', [
            ClientCNIDCard::class,
            ClientHKIDCard::class,
            ClientOtherIDCard::class,
        ], function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientBankCards', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'audited1');
        })->whereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'audited1');
        })->where('status', 'audited1')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewReauditClients()
    {
        $NoOfNews = Client::whereHasMorph('IDCard', [
            ClientCNIDCard::class,
            ClientHKIDCard::class,
            ClientOtherIDCard::class,
        ], function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientAddressProof', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientBankCards', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'reaudit');
        })->orWhere('status', 'reaudit')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewRejectedClients1()
    {
        $NoOfNews = Client::has('EditableSteps')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewDeliverableClients()
    {
        $NoOfNews = Client::doesntHave('AyersAccounts')->whereHasMorph('IDCard', [
            ClientCNIDCard::class,
            ClientHKIDCard::class,
            ClientOtherIDCard::class,
        ], function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientBankCards', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientWorkingStatus', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientFinancialStatus', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientInvestmentExperience', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientEvaluationResults', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientSignature', function (Builder $query) {
            $query->where('status', 'audited2');
        })->whereHas('ClientDepositProof', function (Builder $query) {
            $query->where('status', 'audited2');
        })->where('status', 'audited2')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewSendingEmailClients()
    {
        $NoOfNews = Client::has('AyersAccounts')->doesntHave('SentEmailRecords')->where('type', '拼一手')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewClientFundInRequests()
    {
        $NoOfNews = ClientFundInRequest::where('status', 'pending')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewClientHKFundOutRequests()
    {
        $NoOfNews = ClientHKFundOutRequest::where('status', 'pending')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewClientOverseasFundOutRequests()
    {
        $NoOfNews = ClientOverseasFundOutRequest::where('status', 'pending')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewClientFundInternalTransferRequests()
    {
        $NoOfNews = ClientFundInternalTransferRequest::where('status', 'pending')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }

    public function countNewClientCreditCardFundOutRequests()
    {
        $NoOfNews = ClientCreditCardFundOutRequest::where('status', 'pending')->count();
        return $NoOfNews > 0 ? $NoOfNews : null;
    }
}
