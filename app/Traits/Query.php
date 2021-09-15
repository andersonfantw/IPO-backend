<?php

namespace App\Traits;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\ClientOtherIDCard;
use App\ClientBankCard;
use App\ClientFundInRequest;
use App\ClientHKFundOutRequest;
use Illuminate\Database\Eloquent\Builder;

trait Query
{
    public function getUnauditedList1Query()
    {
        $Query = Client::with(['ViewIntroducer', 'IDCard', 'ClientDepositProof', 'ClientAddressProof'])
            ->has('ClientBusinessType')->whereHasMorph('IDCard', [
                ClientCNIDCard::class,
                ClientHKIDCard::class,
                ClientOtherIDCard::class,
            ], function (Builder $query) {
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
            })->where('status', 'unaudited')
            ->orWhere(function (Builder $query) {
                $query->where('status', 'unaudited')
                    ->where('progress', 16)
                    ->where('idcard_type', 'App\ClientOtherIDCard')
                    ->whereHas('ClientAddressProof', function (Builder $query) {
                        $query->where('status', 'unaudited');
                    });
            });
        return $Query;
    }

    public function getReauditList1Query()
    {
        $Query = Client::with(['ViewIntroducer', 'IDCard', 'ClientDepositProof', 'ClientAddressProof'])
            ->whereHasMorph('IDCard', [
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
            });
        return $Query;
    }

    public function getRejectedList1Query()
    {
        $Query = Client::with(['ViewIntroducer', 'IDCard', 'ClientDepositProof', 'ClientAddressProof'])
            ->whereHas('EditableSteps', function (Builder $query) {
                $query->where('reason', 'correction');
            });
        return $Query;
    }

    public function getUnauditedList2Query()
    {
        $Query = Client::with(['ViewIntroducer', 'IDCard', 'ClientDepositProof', 'ClientAddressProof'])
            ->whereHasMorph('IDCard', [
                ClientCNIDCard::class,
                ClientHKIDCard::class,
                ClientOtherIDCard::class,
            ], function (Builder $query) {
                $query->where('status', 'audited1');
            })->whereHas('ClientWorkingStatus', function (Builder $query) {
                $query->where('status', 'audited1');
            })->whereHas('ClientBankCards', function (Builder $query) {
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
            })->where('status', 'audited1')
            ->orWhere(function (Builder $query) {
                $query->where('status', 'audited1')
                    ->where('progress', 16)
                    ->where('idcard_type', 'App\ClientOtherIDCard')
                    ->whereHas('ClientAddressProof', function (Builder $query) {
                        $query->where('status', 'audited1');
                    });
            });
        return $Query;
    }

    public function getDeliverableList2Query()
    {
        $Query = Client::with(['AyersAccounts', 'IDCard'])
            ->whereHasMorph('IDCard', [
                ClientCNIDCard::class,
                ClientHKIDCard::class,
                ClientOtherIDCard::class,
            ], function (Builder $query) {
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
            })->where('status', 'audited2');
        // ->orWhere(function (Builder $query) {
        //     $query->where('status', 'audited2')
        //         ->where('progress', 16)
        //         ->where('idcard_type', 'App\ClientOtherIDCard');
        // });
        return $Query;
    }

    public function getSendingEmailListQuery()
    {
        $Query = Client::with(['IDCard', 'AyersAccounts', 'SentEmailRecords'])
            ->whereHas('AyersAccounts', function (Builder $query) {
                $query->where('status', '!=', 'suspended');
            })->where('type', '拼一手');
        return $Query;
    }

    public function getClientBankCardsQuery()
    {
        $Query = ClientBankCard::with(['Client', 'Client.AyersAccounts', 'Client.IDCard'])
            ->has('Client.AyersAccounts')
            ->where('type', '拼一手')
            ->whereIn('status', ['approved', 'pending', 'rejected']);
        return $Query;
    }

    public function getClientFundInRequestsQuery()
    {
        $Query = ClientFundInRequest::with(['Client', 'Client.AyersAccounts', 'Client.IDCard']);
        return $Query;
    }

    public function getClientHKFundOutRequestsQuery()
    {
        $Query = ClientHKFundOutRequest::with(['Client', 'Client.AyersAccounts', 'Client.IDCard']);
        return $Query;
    }
}
