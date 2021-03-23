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
        if ($request->has(['駁回銀行卡信息']) && $request->filled(['駁回銀行卡信息'])) {
            $Client->clientBankCard->status = 'rejected';
            $Client->clientBankCard->remark = $input['駁回銀行卡信息'];
            $this->addEditableSteps($Client, 'ClientHKBankCard');
        } else {
            $Client->clientBankCard->status = $input['next_status'];
            $Client->clientBankCard->remark = null;
            $this->deleteEditableSteps($Client, 'ClientHKBankCard');
        }
        $Client->clientBankCard->count_of_audits++;
        $Client->clientBankCard->save();
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
            $Client->clientWorkingStatus->status = 'rejected';
            $Client->clientWorkingStatus->remark = $input['駁回工作狀態'];
            $add = true;
        } else {
            $Client->clientWorkingStatus->status = $input['next_status'];
            $Client->clientWorkingStatus->remark = null;
            $add = false;
        }
        if ($add) {
            $this->addEditableSteps($Client, 'ClientWorkingStatus');
        } else {
            $this->deleteEditableSteps($Client, 'ClientWorkingStatus');
        }
        $Client->clientWorkingStatus->count_of_audits++;
        $Client->clientWorkingStatus->save();
        if ($request->has(['駁回財政狀況']) && $request->filled(['駁回財政狀況'])) {
            $Client->clientFinancialStatus->status = 'rejected';
            $Client->clientFinancialStatus->remark = $input['駁回財政狀況'];
            $add = true;
        } else {
            $Client->clientFinancialStatus->status = $input['next_status'];
            $Client->clientFinancialStatus->remark = null;
            $add = false;
        }
        $Client->clientFinancialStatus->count_of_audits++;
        $Client->clientFinancialStatus->save();
        if ($request->has(['駁回投資經驗及衍生產品認識']) && $request->filled(['駁回投資經驗及衍生產品認識'])) {
            $Client->clientInvestmentExperience->status = 'rejected';
            $Client->clientInvestmentExperience->remark = $input['駁回投資經驗及衍生產品認識'];
            $add = true;
        } else {
            $Client->clientInvestmentExperience->status = $input['next_status'];
            $Client->clientInvestmentExperience->remark = null;
            $add = false;
        }
        if ($add) {
            $this->addEditableSteps($Client, 'ClientFinancialStatus');
        } else {
            $this->deleteEditableSteps($Client, 'ClientFinancialStatus');
        }
        $Client->clientInvestmentExperience->count_of_audits++;
        $Client->clientInvestmentExperience->save();
        if ($request->has(['駁回問卷調查']) && $request->filled(['駁回問卷調查'])) {
            $Client->clientEvaluationResults->status = 'rejected';
            $Client->clientEvaluationResults->remark = $input['駁回問卷調查'];
            $this->addEditableSteps($Client, 'ClientInvestmentOrientation');
            $this->addEditableSteps($Client, 'ClientEvaluationResults');
        } else {
            $Client->clientEvaluationResults->status = $input['next_status'];
            $Client->clientEvaluationResults->remark = null;
            $this->deleteEditableSteps($Client, 'ClientInvestmentOrientation');
            $this->deleteEditableSteps($Client, 'ClientEvaluationResults');
        }
        $Client->clientEvaluationResults->count_of_audits++;
        $Client->clientEvaluationResults->save();
        if ($request->has(['駁回簽名']) && $request->filled(['駁回簽名'])) {
            $Client->clientSignature->status = 'rejected';
            $Client->clientSignature->remark = $input['駁回簽名'];
            $this->addEditableSteps($Client, 'Signature');
        } else {
            $Client->clientSignature->status = $input['next_status'];
            $Client->clientSignature->remark = null;
            $this->deleteEditableSteps($Client, 'Signature');
        }
        $Client->clientSignature->count_of_audits++;
        $Client->clientSignature->save();
        return redirect()->route($input['redirect_route']);
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $parameters['next_status'] = $request->input('next_status');
        return $parameters;
    }

}
