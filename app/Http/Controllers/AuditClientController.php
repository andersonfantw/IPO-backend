<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use App\EditableSteps;
use Illuminate\Http\Request;

class AuditClientController extends HomeController
{

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

    public function loadIDCardFace(Request $request)
    {
        $Client = session('Client');
        return response()->file(storage_path("app/upload/$Client->uuid/{$Client->IDCard->idcard_face}"));
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $Client = Client::where('uuid', $input['uuid'])->first();
        session(['Client' => $Client]);
        $params = ['menu' => json_encode($this->getMenu())];
        $params['uuid'] = $Client->uuid;
        $params['redirect_route'] = $input['redirect_route'];
        $params['next_status'] = $input['next_status'];
        $params['地區'] = $Client->nationality;
        $params['介紹人'] = $Client->introducer_uuid;
        if ($Client->idcard_type == ClientHKIDCard::class) {
            $params['姓名'] = $Client->IDCard->name_tc;
            $params['英文名'] = $Client->IDCard->name_en;
            $params['性別'] = $Client->IDCard->gender;
            $params['出生日期'] = $Client->IDCard->birthday;
            $params['證件號碼'] = $Client->IDCard->idcard_no;
            $params['idcard_face'] = $Client->IDCard->idcard_face;
            $params['idcard_back'] = $Client->IDCard->idcard_back;
        } elseif ($Client->idcard_type == ClientCNIDCard::class) {
            $params['姓名'] = $Client->IDCard->name_sc;
            $params['英文名'] = "{$Client->IDCard->surname}{$Client->IDCard->given_name}";
            $params['性別'] = $Client->IDCard->gender;
            $params['出生日期'] = $Client->IDCard->birthday;
            $params['住址'] = $Client->IDCard->idcard_address;
            $params['證件號碼'] = $Client->IDCard->idcard_no;
            $params['idcard_face'] = $Client->IDCard->idcard_face;
            $params['idcard_back'] = $Client->IDCard->idcard_back;
        }
        if ($Client->clientAddressProof) {
            $params['住址'] = $Client->clientAddressProof->detailed_address;
        }
        $params['手機號碼'] = $Client->mobile;
        $params['銀行'] = $Client->clientBankCard->bank_name;
        $params['銀行卡號'] = $Client->clientBankCard->account_no;
        $params['backcard_face'] = $Client->clientBankCard->backcard_face;
        $params['教育程度'] = $Client->education_level;
        $params['工作狀態'] = $Client->clientWorkingStatus->working_status;
        $params['雇主名稱'] = $Client->clientWorkingStatus->company_name;
        $params['公司電話'] = $Client->clientWorkingStatus->company_tel;
        $params['公司地址'] = null;
        $params['業務性質'] = $Client->clientWorkingStatus->industry;
        $params['服務年資'] = null;
        $params['職位'] = $Client->clientWorkingStatus->position;
        $params['name_card_face'] = $Client->clientWorkingStatus->name_card_face;
        $params['資金來源'] = $Client->clientFinancialStatus->fund_source;
        $params['其他資金來源'] = $Client->clientFinancialStatus->other_fund_source;
        $params['每年收入'] = $Client->clientFinancialStatus->annual_income;
        $params['資產項目'] = null;
        $params['其他資產'] = null;
        $params['資產淨值'] = $Client->clientFinancialStatus->net_assets;
        $params['投資目標'] = $Client->clientInvestmentExperience->investment_objective;
        $params['股票'] = $Client->clientInvestmentExperience->stock;
        $params['衍生認股證'] = $Client->clientInvestmentExperience->derivative_warrants;
        $params['牛熊證'] = $Client->clientInvestmentExperience->cbbc;
        $params['期貨及期權'] = $Client->clientInvestmentExperience->futures_and_options;
        $params['債券基金'] = $Client->clientInvestmentExperience->bonds_funds;
        $params['其他投資經驗'] = $Client->clientInvestmentExperience->other_investment_experience;
        $params['是否有意進行衍生產品投資'] = $Client->clientInvestmentExperience->intend_to_invest_in_derivatives;
        $params['問卷調查'] = $Client->clientInvestmentOrientation->toJson(JSON_UNESCAPED_UNICODE);
        $params['用戶是否同意'] = $Client->clientEvaluationResults->agree;
        $params['簽名'] = $Client->clientSignature->image;
        $params['直接促銷'] = $Client->clientBusinessType->direct_promotion;
        return view('AuditClient', $params);
    }
}
