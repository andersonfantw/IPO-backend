<?php

namespace App\Http\Controllers;

use App\Client;
use App\EditableSteps;
use Illuminate\Http\Request;

class AuditClientController extends ViewClientController
{
    protected $name = 'AuditClient';

    private function addEditableSteps(Client $Client, String $Progress)
    {
        $step = config("progress.Progress.$Progress.$Client->nationality");
        EditableSteps::firstOrCreate(['uuid' => $Client->uuid, 'step' => $step]);
    }

    private function deleteEditableSteps(Client $Client, String $Progress)
    {
        $step = config("progress.Progress.$Progress.$Client->nationality");
        EditableSteps::where('uuid', $Client->uuid)->where('step', $step)->delete();
    }

    public function audit1(Request $request)
    {
        $input = $request->all();
        $Client = Client::where('uuid', $input['uuid'])->first();
        if ($request->has(['駁回身份證信息']) && $request->filled(['駁回身份證信息'])) {
            $Client->IDCard->status = 'rejected';
            $Client->IDCard->remark = $input['駁回身份證信息'];
            $this->addEditableSteps($Client, 'ClientIDCard');
        } else {
            $Client->IDCard->status = $input['next_status'];
            $Client->IDCard->remark = null;
            $this->deleteEditableSteps($Client, 'ClientIDCard');
        }
        $Client->IDCard->count_of_audits++;
        $Client->IDCard->save();

        if ($request->has(['駁回住址證明']) && $request->filled(['駁回住址證明'])) {
            $Client->ClientAddressProof->status = 'rejected';
            $Client->ClientAddressProof->remark = $input['駁回住址證明'];
            $this->addEditableSteps($Client, 'AddressProof');
        } else {
            $Client->ClientAddressProof->status = $input['next_status'];
            $Client->ClientAddressProof->remark = null;
            $this->deleteEditableSteps($Client, 'AddressProof');
        }
        $Client->ClientAddressProof->count_of_audits++;
        $Client->ClientAddressProof->save();

        foreach ($Client->ClientBankCards as $ClientBankCard) {
            if ($request->has(["駁回{$ClientBankCard->lcid}銀行卡信息"]) && $request->filled(["駁回{$ClientBankCard->lcid}銀行卡信息"])) {
                $ClientBankCard->status = 'rejected';
                $ClientBankCard->remark = $input["駁回{$ClientBankCard->lcid}銀行卡信息"];
                if ($ClientBankCard->lcid == 'zh-hk') {
                    $this->addEditableSteps($Client, 'ClientHKBankCard');
                } elseif ($ClientBankCard->lcid == 'zh-cn') {
                    $this->addEditableSteps($Client, 'ClientMainlandBankCard');
                }
            } else {
                $ClientBankCard->status = $input['next_status'];
                $ClientBankCard->remark = null;
                if ($ClientBankCard->lcid == 'zh-hk') {
                    $this->deleteEditableSteps($Client, 'ClientHKBankCard');
                } elseif ($ClientBankCard->lcid == 'zh-cn') {
                    $this->deleteEditableSteps($Client, 'ClientMainlandBankCard');
                }
            }
            $ClientBankCard->count_of_audits++;
            $ClientBankCard->save();
        }

        $add = false;
        if ($request->has(['駁回客戶補充資料']) && $request->filled(['駁回客戶補充資料'])) {
            $Client->status = 'rejected';
            $Client->remark = $input['駁回客戶補充資料'];
            $add = true;
        } else {
            $Client->status = $input['next_status'];
            $Client->remark = null;
            $add = false;
        }
        $Client->count_of_audits++;
        $Client->save();
        if ($request->has(['駁回工作狀態']) && $request->filled(['駁回工作狀態'])) {
            $Client->ClientWorkingStatus->status = 'rejected';
            $Client->ClientWorkingStatus->remark = $input['駁回工作狀態'];
            $add = true;
        } else {
            $Client->ClientWorkingStatus->status = $input['next_status'];
            $Client->ClientWorkingStatus->remark = null;
            $add = false;
        }
        if ($add) {
            $this->addEditableSteps($Client, 'ClientWorkingStatus');
        } else {
            $this->deleteEditableSteps($Client, 'ClientWorkingStatus');
        }
        $Client->ClientWorkingStatus->count_of_audits++;
        $Client->ClientWorkingStatus->save();
        if ($request->has(['駁回財政狀況']) && $request->filled(['駁回財政狀況'])) {
            $Client->ClientFinancialStatus->status = 'rejected';
            $Client->ClientFinancialStatus->remark = $input['駁回財政狀況'];
            $add = true;
        } else {
            $Client->ClientFinancialStatus->status = $input['next_status'];
            $Client->ClientFinancialStatus->remark = null;
            $add = false;
        }
        $Client->ClientFinancialStatus->count_of_audits++;
        $Client->ClientFinancialStatus->save();
        if ($request->has(['駁回投資經驗及衍生產品認識']) && $request->filled(['駁回投資經驗及衍生產品認識'])) {
            $Client->ClientInvestmentExperience->status = 'rejected';
            $Client->ClientInvestmentExperience->remark = $input['駁回投資經驗及衍生產品認識'];
            $add = true;
        } else {
            $Client->ClientInvestmentExperience->status = $input['next_status'];
            $Client->ClientInvestmentExperience->remark = null;
            $add = false;
        }
        if ($add) {
            $this->addEditableSteps($Client, 'ClientFinancialStatus');
        } else {
            $this->deleteEditableSteps($Client, 'ClientFinancialStatus');
        }
        $Client->ClientInvestmentExperience->count_of_audits++;
        $Client->ClientInvestmentExperience->save();
        if ($request->has(['駁回問卷調查']) && $request->filled(['駁回問卷調查'])) {
            $Client->ClientEvaluationResults->status = 'rejected';
            $Client->ClientEvaluationResults->remark = $input['駁回問卷調查'];
            $this->addEditableSteps($Client, 'ClientInvestmentOrientation');
            $this->addEditableSteps($Client, 'ClientEvaluationResults');
        } else {
            $Client->ClientEvaluationResults->status = $input['next_status'];
            $Client->ClientEvaluationResults->remark = null;
            $this->deleteEditableSteps($Client, 'ClientInvestmentOrientation');
            $this->deleteEditableSteps($Client, 'ClientEvaluationResults');
        }
        $Client->ClientEvaluationResults->count_of_audits++;
        $Client->ClientEvaluationResults->save();
        if ($request->has(['駁回簽名']) && $request->filled(['駁回簽名'])) {
            $Client->ClientSignature->status = 'rejected';
            $Client->ClientSignature->remark = $input['駁回簽名'];
            $this->addEditableSteps($Client, 'Signature');
        } else {
            $Client->ClientSignature->status = $input['next_status'];
            $Client->ClientSignature->remark = null;
            $this->deleteEditableSteps($Client, 'Signature');
        }
        $Client->ClientSignature->count_of_audits++;
        $Client->ClientSignature->save();

        if ($request->has(['駁回存款證明']) && $request->filled(['駁回存款證明'])) {
            $Client->ClientDepositProof->status = 'rejected';
            $Client->ClientDepositProof->remark = $input['駁回存款證明'];
            $this->addEditableSteps($Client, 'DepositProof');
        } else {
            $Client->ClientDepositProof->status = $input['next_status'];
            $Client->ClientDepositProof->remark = null;
            $this->deleteEditableSteps($Client, 'DepositProof');
        }
        $Client->ClientDepositProof->count_of_audits++;
        $Client->ClientDepositProof->save();

        return redirect()->route($input['redirect_route']);
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $parameters['next_status'] = $request->input('next_status');
        return $parameters;
    }

}
