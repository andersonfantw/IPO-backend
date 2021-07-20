<?php

namespace App\Http\Controllers;

use App\Client;
use App\Traits\Score;
use Illuminate\Http\Request;

class ViewClientController extends HomeController
{
    use Score;

    protected $name = 'ViewClient';

    public function loadIDCardFace(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->IDCard->idcard_face)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->IDCard->idcard_face}"));
    }

    public function loadIDCardBack(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->IDCard->idcard_back)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->IDCard->idcard_back}"));
    }

    public function loadHKBankCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        $ClientBankCard = $Client->ClientBankCards()->where('lcid', 'zh-hk')->first();
        return response($ClientBankCard->bankcard_blob)->header('Content-Type', 'image/jpeg');
    }

    public function loadCNBankCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        $ClientBankCard = $Client->ClientBankCards()->where('lcid', 'zh-cn')->first();
        if (is_object($ClientBankCard)) {
            return response($ClientBankCard->bankcard_blob)->header('Content-Type', 'image/jpeg');
        } else {
            return null;
        }
    }

    public function loadOtherBankCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        $ClientBankCard = $Client->ClientBankCards()->where('lcid', 'others')->first();
        return response($ClientBankCard->bankcard_blob)->header('Content-Type', 'image/jpeg');
    }

    public function loadNameCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->ClientWorkingStatus->name_card_face)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->ClientWorkingStatus->name_card_face}"));
    }

    public function loadSignature(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($this->base64ToBlob($Client->ClientSignature->image))->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->ClientSignature->image}"));
    }

    public function loadDepositProof(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->ClientDepositProof->image)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->ClientDepositProof->image}"));
    }

    public function loadAddressProof(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response($Client->ClientAddressProof->image)->header('Content-Type', 'image/jpeg');
        // return response()->file(storage_path("app/upload/$Client->uuid/{$Client->ClientAddressProof->image}"));
    }

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
            'ViewClientScore',
            'ClientEvaluationResults',
            'ClientSignature',
            'ClientBusinessType',
            'ClientDepositProof',
            'ViewIntroducer',
        ])
            ->where('uuid', $request->input('uuid'))->first();
        $Client->idcard_type = addslashes($Client->idcard_type);
        $Client->education_level = addslashes($Client->education_level);
        $Client->selected_flow = addslashes($Client->selected_flow);
        $details['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);
        $Client->idcard_type = stripslashes($Client->idcard_type);
        $details['uuid'] = $Client->uuid;
        $Client->IDCard->idcard_face = null;
        $Client->IDCard->idcard_back = null;
        $details['ClientIDCard'] = $Client->IDCard->toJson(JSON_UNESCAPED_UNICODE);
        if (is_object($Client->ClientAddressProof)) {
            $Client->ClientAddressProof->image = null;
            $Client->ClientAddressProof->detailed_address = addslashes($Client->ClientAddressProof->detailed_address);
            $details['ClientAddressProof'] = $Client->ClientAddressProof->toJson(JSON_UNESCAPED_UNICODE);
            $Client->ClientAddressProof->detailed_address = stripslashes($Client->ClientAddressProof->detailed_address);
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
        // $details['ClientScore'] = $Client->ViewClientScore->toJson(JSON_UNESCAPED_UNICODE);
        $details['ClientScore'] = json_encode(calculateClientScore($Client), JSON_UNESCAPED_UNICODE);
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
        return $details;
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $input = $request->all();
        $Client = Client::where('uuid', $input['uuid'])->first();
        $Client->idcard_type = addslashes($Client->idcard_type);
        $Client->education_level = addslashes($Client->education_level);
        $Client->selected_flow = addslashes($Client->selected_flow);
        $parameters['Client'] = $Client->toJson(JSON_UNESCAPED_UNICODE);
        $Client->idcard_type = stripslashes($Client->idcard_type);
        $Client->education_level = stripslashes($Client->education_level);
        $Client->selected_flow = stripslashes($Client->selected_flow);
        $parameters['uuid'] = $Client->uuid;
        $parameters['redirect_route'] = $input['redirect_route'];
        $Client->IDCard->idcard_face = null;
        $Client->IDCard->idcard_back = null;
        $parameters['ClientIDCard'] = $Client->IDCard->toJson(JSON_UNESCAPED_UNICODE);
        if (is_object($Client->ClientAddressProof)) {
            $Client->ClientAddressProof->image = null;
            $Client->ClientAddressProof->detailed_address = addslashes($Client->ClientAddressProof->detailed_address);
            $parameters['ClientAddressProof'] = $Client->ClientAddressProof->toJson(JSON_UNESCAPED_UNICODE);
            $Client->ClientAddressProof->detailed_address = stripslashes($Client->ClientAddressProof->detailed_address);
        } else {
            $parameters['ClientAddressProof'] = null;
        }
        foreach ($Client->ClientBankCards as &$ClientBankCard) {
            $ClientBankCard->bankcard_blob = null;
        }
        $parameters['ClientBankCards'] = $Client->ClientBankCards->toJson(JSON_UNESCAPED_UNICODE);
        if ($Client->ClientWorkingStatus->name_card_face) {
            $Client->ClientWorkingStatus->name_card_face = null;
        }
        $parameters['ClientWorkingStatus'] = $Client->ClientWorkingStatus->toJson(JSON_UNESCAPED_UNICODE);
        $Client->ClientFinancialStatus->fund_source = addslashes($Client->ClientFinancialStatus->fund_source);
        $parameters['ClientFinancialStatus'] = $Client->ClientFinancialStatus->toJson(JSON_UNESCAPED_UNICODE);
        $Client->ClientFinancialStatus->fund_source = stripslashes($Client->ClientFinancialStatus->fund_source);
        $parameters['ClientInvestmentExperience'] = $Client->ClientInvestmentExperience->toJson(JSON_UNESCAPED_UNICODE);
        $parameters['ClientScore'] = $Client->ViewClientScore->toJson(JSON_UNESCAPED_UNICODE);
        // $parameters['ClientScore'] = '[]';
        $parameters['ClientEvaluationResults'] = $Client->ClientEvaluationResults->toJson(JSON_UNESCAPED_UNICODE);
        $parameters['ClientSignature'] = $Client->ClientSignature->toJson(JSON_UNESCAPED_UNICODE);
        $Client->ClientBusinessType->direct_promotion = addslashes($Client->ClientBusinessType->direct_promotion);
        $parameters['ClientBusinessType'] = $Client->ClientBusinessType->toJson(JSON_UNESCAPED_UNICODE);
        $Client->ClientBusinessType->direct_promotion = stripslashes($Client->ClientBusinessType->direct_promotion);
        if (is_object($Client->ClientDepositProof)) {
            $Client->ClientDepositProof->image = null;
            $parameters['ClientDepositProof'] = $Client->ClientDepositProof->toJson(JSON_UNESCAPED_UNICODE);
        } else {
            $parameters['ClientDepositProof'] = null;
        }
        $parameters['Introducer'] = $Client->ViewIntroducer->toJson(JSON_UNESCAPED_UNICODE);
        return $parameters;
    }

}
