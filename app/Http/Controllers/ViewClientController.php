<?php

namespace App\Http\Controllers;

use App\Client;
use App\Traits\ImageLoader;
use App\Traits\Score;
use Illuminate\Http\Request;

class ViewClientController extends HomeController
{
    use Score, ImageLoader;

    protected $name = 'ViewClient';

    protected function getClientDetails(Request $request)
    {
        $details = [];
        $Client = Client::with([
            'IDCard',
            'ClientAddressProof',
            'ClientBankCards',
            'ClientWorkingStatus',
            'ClientFinancialStatus',
            'ClientInvestmentExperience',
            'ViewClientQuestionnaire',
            'ClientEvaluationResults',
            'ClientSignature',
            'ClientBusinessType',
            'ClientDepositProof',
            'ViewIntroducer',
        ])
            ->where('uuid', $request->input('uuid'))->first();
        $details['uuid'] = $Client->uuid;
        $Client->IDCard->idcard_face = null;
        $Client->IDCard->idcard_back = null;
        $details['ClientIDCard'] = $Client->IDCard->toJson(JSON_UNESCAPED_UNICODE);
        if (is_object($Client->ClientAddressProof)) {
            $Client->ClientAddressProof->image = null;
            $Client->ClientAddressProof->detailed_address = addslashes($Client->ClientAddressProof->detailed_address);
            $details['ClientAddressProof'] = $Client->ClientAddressProof->toJson(JSON_UNESCAPED_UNICODE);
            // $Client->ClientAddressProof->detailed_address = stripslashes($Client->ClientAddressProof->detailed_address);
        } else {
            $details['ClientAddressProof'] = null;
        }
        foreach ($Client->ClientBankCards as &$ClientBankCard) {
            $ClientBankCard->bankcard_blob = null;
        }
        $details['ClientBankCards'] = $Client->ClientBankCards->toJson(JSON_UNESCAPED_UNICODE);
        if ($Client->ClientWorkingStatus->name_card_face) {
            $Client->ClientWorkingStatus->name_card_face = null;
        }
        $details['ClientWorkingStatus'] = $Client->ClientWorkingStatus->toJson(JSON_UNESCAPED_UNICODE);
        $Client->ClientFinancialStatus->fund_source = addslashes($Client->ClientFinancialStatus->fund_source);
        $details['ClientFinancialStatus'] = $Client->ClientFinancialStatus->toJson(JSON_UNESCAPED_UNICODE);
        $details['ClientInvestmentExperience'] = $Client->ClientInvestmentExperience->toJson(JSON_UNESCAPED_UNICODE);
        $details['ClientScore'] = json_encode($this->calculateClientScore($Client), JSON_UNESCAPED_UNICODE);
        $details['ClientEvaluationResults'] = $Client->ClientEvaluationResults->toJson(JSON_UNESCAPED_UNICODE);
        $details['ClientSignature'] = $Client->ClientSignature->toJson(JSON_UNESCAPED_UNICODE);
        $Client->ClientBusinessType->direct_promotion = addslashes($Client->ClientBusinessType->direct_promotion);
        $details['ClientBusinessType'] = $Client->ClientBusinessType->toJson(JSON_UNESCAPED_UNICODE);
        if (is_object($Client->ClientDepositProof)) {
            $Client->ClientDepositProof->image = null;
            $details['ClientDepositProof'] = $Client->ClientDepositProof->toJson(JSON_UNESCAPED_UNICODE);
        } else {
            $details['ClientDepositProof'] = null;
        }
        $details['Introducer'] = $Client->ViewIntroducer->toJson(JSON_UNESCAPED_UNICODE);
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        $Client->idcard_type = addslashes($Client->idcard_type);
        $Client->education_level = addslashes($Client->education_level);
        $Client->selected_flow = addslashes($Client->selected_flow);
        $details['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);
        // $Client->idcard_type = stripslashes($Client->idcard_type);
        return $details;
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $parameters['redirect_route'] = $request->input('redirect_route');
        $details = $this->getClientDetails($request);
        return array_merge($parameters, $details);
    }

}
