<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientRejectionLog;
use App\EditableSteps;
use App\Traits\SMS;
use Illuminate\Http\Request;

class AuditClientController extends ViewClientController
{
    use SMS;

    protected $name = 'AuditClient';

    private function addEditableSteps(Client $Client, String $Progress)
    {
        $selected_flow = json_decode($Client->selected_flow, true);
        $selected_flow = implode('.', $selected_flow);
        dd("progress.Progress.$Progress.$selected_flow");
        $step = config("progress.Progress.$Progress.$selected_flow");
        EditableSteps::firstOrCreate(['uuid' => $Client->uuid, 'step' => $step, 'reason' => 'correction']);
    }

    private function deleteEditableSteps(Client $Client, String $Progress)
    {
        $selected_flow = json_decode($Client->selected_flow, true);
        $selected_flow = implode('.', $selected_flow);
        $step = config("progress.Progress.$Progress.$selected_flow");
        EditableSteps::where('uuid', $Client->uuid)->where('step', $step)->where('reason', 'correction')->delete();
    }

    public function audit1(Request $request)
    {
        $input = $request->all();
        $Client = Client::where('uuid', $input['uuid'])->first();
        $rejected = false;
        if ($request->has(['駁回身份證信息']) && $request->filled(['駁回身份證信息'])) {
            $Client->IDCard->status = 'rejected';
            $Client->IDCard->remark = $input['駁回身份證信息'];
            $this->addEditableSteps($Client, 'ClientIDCard');
            ClientRejectionLog::create([
                'uuid' => $Client->uuid,
                'rejected_section' => get_class($Client->IDCard),
                'remark' => $input['駁回身份證信息'],
            ]);
            $rejected = true;
        } else {
            $Client->IDCard->status = $input['next_status'];
            $Client->IDCard->remark = null;
            $this->deleteEditableSteps($Client, 'ClientIDCard');
        }
        $Client->IDCard->count_of_audits++;
        $Client->IDCard->save();

        if (is_object($Client->ClientAddressProof)) {
            if ($request->has(['駁回住址證明']) && $request->filled(['駁回住址證明'])) {
                $Client->ClientAddressProof->status = 'rejected';
                $Client->ClientAddressProof->remark = $input['駁回住址證明'];
                $this->addEditableSteps($Client, 'AddressProof');
                ClientRejectionLog::create([
                    'uuid' => $Client->uuid,
                    'rejected_section' => get_class($Client->ClientAddressProof),
                    'remark' => $input['駁回住址證明'],
                ]);
                $rejected = true;
            } else {
                $Client->ClientAddressProof->status = $input['next_status'];
                $Client->ClientAddressProof->remark = null;
                $this->deleteEditableSteps($Client, 'AddressProof');
            }
            $Client->ClientAddressProof->count_of_audits++;
            $Client->ClientAddressProof->save();
        }

        foreach ($Client->ClientBankCards as $ClientBankCard) {
            if ($request->has(["駁回{$ClientBankCard->lcid}銀行卡信息"]) && $request->filled(["駁回{$ClientBankCard->lcid}銀行卡信息"])) {
                $ClientBankCard->status = 'rejected';
                $ClientBankCard->remark = $input["駁回{$ClientBankCard->lcid}銀行卡信息"];
                if ($ClientBankCard->lcid == 'zh-hk') {
                    $this->addEditableSteps($Client, 'ClientHKBankCard');
                } elseif ($ClientBankCard->lcid == 'zh-cn') {
                    $this->addEditableSteps($Client, 'ClientMainlandBankCard');
                } elseif ($ClientBankCard->lcid == 'others') {
                    $this->addEditableSteps($Client, 'ClientOtherBankCard');
                }
                ClientRejectionLog::create([
                    'uuid' => $Client->uuid,
                    'rejected_section' => get_class($ClientBankCard),
                    'remark' => $input["駁回{$ClientBankCard->lcid}銀行卡信息"],
                ]);
                $rejected = true;
            } else {
                $ClientBankCard->status = $input['next_status'];
                $ClientBankCard->remark = null;
                if ($ClientBankCard->lcid == 'zh-hk') {
                    $this->deleteEditableSteps($Client, 'ClientHKBankCard');
                } elseif ($ClientBankCard->lcid == 'zh-cn') {
                    $this->deleteEditableSteps($Client, 'ClientMainlandBankCard');
                } elseif ($ClientBankCard->lcid == 'others') {
                    $this->deleteEditableSteps($Client, 'ClientOtherBankCard');
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
            ClientRejectionLog::create([
                'uuid' => $Client->uuid,
                'rejected_section' => get_class($Client),
                'remark' => $input["駁回客戶補充資料"],
            ]);
            $rejected = true;
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
            ClientRejectionLog::create([
                'uuid' => $Client->uuid,
                'rejected_section' => get_class($Client->ClientWorkingStatus),
                'remark' => $input["駁回工作狀態"],
            ]);
            $rejected = true;
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
            ClientRejectionLog::create([
                'uuid' => $Client->uuid,
                'rejected_section' => get_class($Client->ClientFinancialStatus),
                'remark' => $input["駁回財政狀況"],
            ]);
            $rejected = true;
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
            ClientRejectionLog::create([
                'uuid' => $Client->uuid,
                'rejected_section' => get_class($Client->ClientInvestmentExperience),
                'remark' => $input["駁回投資經驗及衍生產品認識"],
            ]);
            $rejected = true;
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
            ClientRejectionLog::create([
                'uuid' => $Client->uuid,
                'rejected_section' => get_class($Client->ClientEvaluationResults),
                'remark' => $input["駁回問卷調查"],
            ]);
            $rejected = true;
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
            ClientRejectionLog::create([
                'uuid' => $Client->uuid,
                'rejected_section' => get_class($Client->ClientSignature),
                'remark' => $input["駁回簽名"],
            ]);
            $rejected = true;
        } else {
            $Client->ClientSignature->status = $input['next_status'];
            $Client->ClientSignature->remark = null;
            $this->deleteEditableSteps($Client, 'Signature');
        }
        $Client->ClientSignature->count_of_audits++;
        $Client->ClientSignature->save();

        if ($request->has(['駁回存款證明']) && $request->filled(['駁回存款證明'])) {
            if (is_object($Client->ClientDepositProof)) {
                $Client->ClientDepositProof->status = 'rejected';
                $Client->ClientDepositProof->remark = $input['駁回存款證明'];
            }
            $this->addEditableSteps($Client, 'DepositProof');
            ClientRejectionLog::create([
                'uuid' => $Client->uuid,
                'rejected_section' => get_class($Client->ClientDepositProof),
                'remark' => $input["駁回存款證明"],
            ]);
            $rejected = true;
        } else {
            if (is_object($Client->ClientDepositProof)) {
                $Client->ClientDepositProof->status = $input['next_status'];
                $Client->ClientDepositProof->remark = null;
            }
            $this->deleteEditableSteps($Client, 'DepositProof');
        }
        if (is_object($Client->ClientDepositProof)) {
            $Client->ClientDepositProof->count_of_audits++;
            $Client->ClientDepositProof->save();
        }
        if (env('IS_PRODUCTION') && $rejected) {
            return $this->sendRejectionSMS($Client);
        }
        return redirect()->route($input['redirect_route']);
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $parameters['next_status'] = $request->input('next_status');
        return $parameters;
    }

}
