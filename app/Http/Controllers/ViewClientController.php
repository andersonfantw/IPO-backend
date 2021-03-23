<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientCNIDCard;
use App\ClientHKIDCard;
use Illuminate\Http\Request;

class ViewClientController extends HomeController
{
    protected $name = 'ViewClient';

    public function loadIDCardFace(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response()->file(storage_path("app/upload/$Client->uuid/{$Client->IDCard->idcard_face}"));
    }

    public function loadIDCardBack(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response()->file(storage_path("app/upload/$Client->uuid/{$Client->IDCard->idcard_back}"));
    }

    public function loadBankCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response()->file(storage_path("app/upload/$Client->uuid/{$Client->clientBankCard->backcard_face}"));
    }

    public function loadNameCard(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response()->file(storage_path("app/upload/$Client->uuid/{$Client->clientWorkingStatus->name_card_face}"));
    }

    public function loadSignature(Request $request)
    {
        $Client = Client::where('uuid', $request->input('uuid'))->first();
        return response()->file(storage_path("app/upload/$Client->uuid/{$Client->clientSignature->image}"));
    }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $input = $request->all();
        $Client = Client::where('uuid', $input['uuid'])->first();
        $parameters['uuid'] = $Client->uuid;
        $parameters['redirect_route'] = $input['redirect_route'];
        $parameters['地區'] = $Client->nationality;
        $parameters['介紹人'] = $Client->introducer_uuid;
        $parameters['Client_remark'] = $Client->remark;
        if ($Client->idcard_type == ClientHKIDCard::class) {
            $parameters['姓名'] = $Client->IDCard->name_tc;
            $parameters['英文名'] = $Client->IDCard->name_en;
        } elseif ($Client->idcard_type == ClientCNIDCard::class) {
            $parameters['姓名'] = $Client->IDCard->name_sc;
            $parameters['英文名'] = "{$Client->IDCard->surname}{$Client->IDCard->given_name}";
            $parameters['住址'] = $Client->IDCard->idcard_address;
        }
        $parameters['性別'] = $Client->IDCard->gender;
        $parameters['出生日期'] = $Client->IDCard->birthday;
        $parameters['證件號碼'] = $Client->IDCard->idcard_no;
        $parameters['idcard_face'] = $Client->IDCard->idcard_face;
        $parameters['idcard_back'] = $Client->IDCard->idcard_back;
        $parameters['idcard_remark'] = $Client->IDCard->remark;
        if ($Client->clientAddressProof) {
            $parameters['住址'] = $Client->clientAddressProof->detailed_address;
        }
        $parameters['手機號碼'] = $Client->mobile;
        $parameters['銀行'] = $Client->clientBankCard->bank_name;
        $parameters['銀行卡號'] = $Client->clientBankCard->account_no;
        $parameters['backcard_face'] = $Client->clientBankCard->backcard_face;
        $parameters['bankcard_remark'] = $Client->clientBankCard->remark;
        $parameters['教育程度'] = $Client->education_level;
        $parameters['工作狀態'] = $Client->clientWorkingStatus->working_status;
        $parameters['雇主名稱'] = $Client->clientWorkingStatus->company_name;
        $parameters['公司電話'] = $Client->clientWorkingStatus->company_tel;
        $parameters['公司地址'] = null;
        $parameters['業務性質'] = $Client->clientWorkingStatus->industry;
        $parameters['服務年資'] = null;
        $parameters['職位'] = $Client->clientWorkingStatus->position;
        $parameters['name_card_face'] = $Client->clientWorkingStatus->name_card_face;
        $parameters['working_status_remark'] = $Client->clientWorkingStatus->remark;
        $parameters['資金來源'] = $Client->clientFinancialStatus->fund_source;
        $parameters['其他資金來源'] = $Client->clientFinancialStatus->other_fund_source;
        $parameters['每年收入'] = $Client->clientFinancialStatus->annual_income;
        $parameters['資產項目'] = null;
        $parameters['其他資產'] = null;
        $parameters['資產淨值'] = $Client->clientFinancialStatus->net_assets;
        $parameters['financial_status_remark'] = $Client->clientFinancialStatus->remark;
        $parameters['投資目標'] = $Client->clientInvestmentExperience->investment_objective;
        $parameters['股票'] = $Client->clientInvestmentExperience->stock;
        $parameters['衍生認股證'] = $Client->clientInvestmentExperience->derivative_warrants;
        $parameters['牛熊證'] = $Client->clientInvestmentExperience->cbbc;
        $parameters['期貨及期權'] = $Client->clientInvestmentExperience->futures_and_options;
        $parameters['債券基金'] = $Client->clientInvestmentExperience->bonds_funds;
        $parameters['其他投資經驗'] = $Client->clientInvestmentExperience->other_investment_experience;
        $parameters['是否有意進行衍生產品投資'] = $Client->clientInvestmentExperience->intend_to_invest_in_derivatives;
        $parameters['investment_experience_remark'] = $Client->clientInvestmentExperience->remark;
        $parameters['問卷調查'] = $Client->clientInvestmentOrientation->toJson(JSON_UNESCAPED_UNICODE);
        $parameters['用戶是否同意'] = $Client->clientEvaluationResults->agree;
        $parameters['evaluation_results_remark'] = $Client->clientEvaluationResults->remark;
        $parameters['簽名'] = $Client->clientSignature->image;
        $parameters['signature_remark'] = $Client->clientSignature->remark;
        $parameters['直接促銷'] = $Client->clientBusinessType->direct_promotion;
        return $parameters;
    }

}
