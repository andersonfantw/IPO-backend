<?php
namespace App\Exports;

use App\Client;
use App\Exports\AyersValueBinder;
use App\Traits\Score;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AyersDataExport extends AyersValueBinder implements FromView
{
    use Score;

    private $clients;

    private $Headers;

    private $passport_type;

    private $gender;

    private $nationality;

    private $investment_objective;

    private $employment_status;

    private $annual_income;

    private $net_liquid_assets;

    private $RESIDENCE;

    private $PLACE_OF_BIRTH;

    public function __construct(array $clients)
    {
        $this->clients = $clients;
        $this->Headers = [
            'client_id',
            'name',
            'other_name_big5',
            'other_name_gb',
            'other_name_eng',
            'payee_name',
            'payee_bank_code',
            'payee_bank_acc',
            'passport_type',
            'passport_id',
            'ae_code',
            'alert_remark',
            'email',
            'phone',
            'other_phone',
            'Fax',
            'address_line1',
            'address_line2',
            'address_line3',
            'address_line4',
            'gender',
            'DATE_OF_BIRTH',
            'remark',
            'statement_lang',
            'nationality',
            'client_type',
            'buss_nature',
            'invest_obj',
            'other_invest_ob',
            'client_group_code',
            'author_person',
            'contact_person',
            'stmt_mail',
            'stmt_email',
            'stmt_email_monthly',
            'conf_email',
            'conf_fax',
            'acc_code',
            'acc_type',
            'status',
            'open_date',
            'close_date',
            'loan_limit',
            'loan_expiry_date',
            'trading_limit',
            'clearing_acc_type',
            'internet_trading',
            'mobile_trading',
            'IVRS_trading',
            'mango_Trading',
            'stmt_remark',
            'stmt_fax',
            'stmt_hold',
            'stmt_byhand',
            'stmt_other',
            'employment_status',
            'employment_name',
            'occupation',
            'occupation_other',
            'office_addr_line1',
            'office_addr_line2',
            'office_addr_line3',
            'office_addr_line4',
            'annual_income',
            'net_liquid_assets',
            'fund_source',
            'fund_source_other',
            'investment_knowledge',
            'sec_knowledge',
            'optwrt_knowledge',
            'fut_knowledge',
            'fxmetal_knowledge',
            'derivative_knowledge',
            'pi',
            'acc_code_prefix',
            'NON_FACE_TO_FACE',
            'RISK_TOLERANCE_LEVEL_EXPERIENCE',
            'RISK_TOLERANCE_LEVEL_TRADE',
            'client_acc_ae_code',
            'RESIDENCE',
            'PLACE_OF_BIRTH',
        ];
        $this->passport_type = [
            'App\ClientHKIDCard' => 'IDHK',
            'App\ClientCNIDCard' => 'IDCN',
            'App\ClientOtherIDCard' => 'IDOTHER',
        ];
        $this->gender = [
            '男' => 'MR',
            '女' => 'MS',
        ];
        $this->nationality = [
            'zh-hk' => 'HKG',
            'zh-cn' => 'CHN',
            'others' => 'TW',
        ];
        $this->investment_objective = [
            '股息收入' => 1,
            '資本增值' => 2,
            '资本增值' => 2,
            '投機' => 3,
            '投机' => 3,
            '對沖' => 4,
            '对冲' => 4,
            '其他' => 5,
        ];
        $this->employment_status = [
            '單位任職' => 1,
            '单位任职' => 1,
            '自主創業' => 2,
            '自主创业' => 2,
            '退休' => 3,
            '家庭主婦' => 4,
            '家庭主妇' => 4,
            '學生' => 5,
            '学生' => 5,
        ];
        $this->annual_income = [
            '<100001' => 1,
            '100001-360000' => 2,
            '360001-600000' => 3,
            '600001-1200000' => 4,
            '>1200000' => 5,
        ];
        $this->net_liquid_assets = [
            '<100001' => 1,
            '100001-360000' => 2,
            '360001-600000' => 3,
            '600001-1200000' => 4,
            '>1200000' => 5,
        ];
        $this->RESIDENCE = [
            'zh-hk' => 'HK',
            'zh-cn' => 'CN',
            'others' => 'TW',
        ];
        $this->PLACE_OF_BIRTH = [
            'zh-hk' => 'HKG',
            'zh-cn' => 'CHN',
            'others' => 'TW',
        ];
    }

    public function view(): View
    {
        $uuids = [];
        foreach ($this->clients as $client) {
            $uuids[] = $client['uuid'];
        }
        $Clients = Client::with([
            'AyersAccounts',
            'IDCard',
            'ClientBankCards' => function ($query) {
                $query->whereIn('lcid', ['zh-hk', 'others']);
            },
            'ViewIntroducer',
            'ClientAddressProof',
            'ClientWorkingStatus',
            'ClientInvestmentExperience',
            'ClientFinancialStatus',
            'ViewClientQuestionnaire',
        ])->has('AyersAccounts')
            ->whereIn('uuid', $uuids)->get();
        $AyersImportDatas = [];
        foreach ($Clients as $Client) {
            $ClientScores = $this->calculateClientScore($Client);
            $SumScore = 0;
            foreach ($ClientScores as $ClientScore) {
                $SumScore += $ClientScore['score'];
            }
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $AyersImportData = [];
                $AyersImportData['client_id'] = mb_substr($AyersAccount->account_no, 0, -2);
                if ($Client->IDCard->name_en) {
                    $AyersImportData['name'] = $Client->IDCard->name_en;
                } else {
                    $AyersImportData['name'] = $Client->IDCard->surname . ' ' . $Client->IDCard->given_name;
                }
                if (preg_match("/^\d+13$/i", $AyersAccount->account_no)) {
                    $AyersImportData['name'] .= '-DISCRETIONARY ACCOUNT';
                }
                $AyersImportData['other_name_big5'] = $Client->IDCard->name_c;
                $AyersImportData['other_name_gb'] = null;
                $AyersImportData['other_name_eng'] = $AyersImportData['name'];
                $AyersImportData['payee_name'] = $AyersImportData['name'];
                $AyersImportData['payee_bank_code'] = $Client->ClientBankCards->first()->bank_code;
                $AyersImportData['payee_bank_acc'] = $Client->ClientBankCards->first()->account_no;
                $AyersImportData['passport_type'] = $this->passport_type[$Client->idcard_type];
                $AyersImportData['passport_id'] = $Client->IDCard->idcard_no;
                if (preg_match("/^\d+13$/i", $AyersAccount->account_no)) {
                    $AyersImportData['ae_code'] = $Client->ViewIntroducer->ae_code_13;
                } elseif (preg_match("/^\d+08$/i", $AyersAccount->account_no)) {
                    $AyersImportData['ae_code'] = $Client->ViewIntroducer->ae_code_08;
                }
                $AyersImportData['alert_remark'] = null;
                $AyersImportData['email'] = $Client->email;
                $AyersImportData['phone'] = $Client->mobile;
                $AyersImportData['other_phone'] = null;
                $AyersImportData['Fax'] = null;
                if (is_object($Client->ClientAddressProof)) {
                    $AyersImportData['address_line1'] = $Client->ClientAddressProof->address_text;
                } else {
                    $AyersImportData['address_line1'] = $Client->IDCard->idcard_address;
                }
                $AyersImportData['address_line2'] = null;
                $AyersImportData['address_line3'] = null;
                $AyersImportData['address_line4'] = null;
                $AyersImportData['gender'] = $this->gender[$Client->IDCard->gender];
                $AyersImportData['DATE_OF_BIRTH'] = $Client->IDCard->birthday;
                $AyersImportData['remark'] = null;
                $AyersImportData['statement_lang'] = 'big5';
                $AyersImportData['nationality'] = $this->nationality[$Client->nationality];
                $AyersImportData['client_type'] = 'IV';
                $AyersImportData['buss_nature'] = $Client->ClientWorkingStatus->industry;
                $AyersImportData['invest_obj'] = $this->investment_objective[$Client->ClientInvestmentExperience->investment_objective];
                $AyersImportData['other_invest_ob'] = null;
                if (preg_match("/^\d+13$/i", $AyersAccount->account_no)) {
                    $AyersImportData['client_group_code'] = 'D';
                } elseif (preg_match("/^\d+08$/i", $AyersAccount->account_no)) {
                    $AyersImportData['client_group_code'] = null;
                }
                $AyersImportData['author_person'] = null;
                $AyersImportData['contact_person'] = null;
                $AyersImportData['stmt_mail'] = 'N';
                $AyersImportData['stmt_email'] = 'Y';
                $AyersImportData['stmt_email_monthly'] = 'Y';
                $AyersImportData['conf_email'] = 'Y';
                $AyersImportData['conf_fax'] = 'N';
                $AyersImportData['acc_code'] = substr($AyersAccount->account_no, -2);
                if (preg_match("/^\d+13$/i", $AyersAccount->account_no)) {
                    $AyersImportData['acc_type'] = 'D';
                } elseif (preg_match("/^\d+08$/i", $AyersAccount->account_no)) {
                    $AyersImportData['acc_type'] = 'C';
                }
                $AyersImportData['status'] = 'A';
                $AyersImportData['open_date'] = $AyersAccount->created_at->format('Ymd');
                $AyersImportData['close_date'] = null;
                $AyersImportData['loan_limit'] = null;
                $AyersImportData['loan_expiry_date'] = null;
                $AyersImportData['trading_limit'] = null;
                $AyersImportData['clearing_acc_type'] = null;
                if (preg_match("/^\d+13$/i", $AyersAccount->account_no)) {
                    $AyersImportData['internet_trading'] = 'R';
                    $AyersImportData['mobile_trading'] = 'R';
                } elseif (preg_match("/^\d+08$/i", $AyersAccount->account_no)) {
                    $AyersImportData['internet_trading'] = 'Y';
                    $AyersImportData['mobile_trading'] = 'Y';
                }
                $AyersImportData['IVRS_trading'] = 'N';
                $AyersImportData['mango_Trading'] = 'N';
                $AyersImportData['stmt_remark'] = null;
                $AyersImportData['stmt_fax'] = null;
                $AyersImportData['stmt_hold'] = null;
                $AyersImportData['stmt_byhand'] = null;
                $AyersImportData['stmt_other'] = null;
                $AyersImportData['employment_status'] = $this->employment_status[$Client->ClientWorkingStatus->working_status];
                $AyersImportData['employment_name'] = $Client->ClientWorkingStatus->company_name;
                $AyersImportData['occupation'] = 8;
                $AyersImportData['occupation_other'] = null;
                $AyersImportData['office_addr_line1'] = null;
                $AyersImportData['office_addr_line2'] = null;
                $AyersImportData['office_addr_line3'] = null;
                $AyersImportData['office_addr_line4'] = null;
                $AyersImportData['annual_income'] = $this->annual_income[$Client->ClientFinancialStatus->annual_income];
                $AyersImportData['net_liquid_assets'] = $this->net_liquid_assets[$Client->ClientFinancialStatus->net_assets];
                $AyersImportData['fund_source'] = 1;
                $AyersImportData['fund_source_other'] = $Client->ClientFinancialStatus->other_fund_source;
                $AyersImportData['investment_knowledge'] = null;
                $AyersImportData['sec_knowledge'] = $this->getScoreByAnswer($Client->ClientInvestmentExperience->stock);
                $AyersImportData['optwrt_knowledge'] = $this->getScoreByAnswer($Client->ClientInvestmentExperience->futures_and_options);
                $AyersImportData['fut_knowledge'] = $this->getScoreByAnswer($Client->ClientInvestmentExperience->futures_and_options);
                $AyersImportData['fxmetal_knowledge'] = null;
                if ($Client->ViewClientQuestionnaire->a13 == '是') {
                    $AyersImportData['derivative_knowledge'] = 'N';
                } elseif ($Client->ViewClientQuestionnaire->a13 == '否') {
                    $AyersImportData['derivative_knowledge'] = 'Y';
                }
                $AyersImportData['pi'] = null;
                $AyersImportData['acc_code_prefix'] = null;
                $AyersImportData['NON_FACE_TO_FACE'] = 'Y';
                $AyersImportData['RISK_TOLERANCE_LEVEL_EXPERIENCE'] = $this->getLevel($SumScore);
                $AyersImportData['RISK_TOLERANCE_LEVEL_TRADE'] = $this->getLevel($SumScore);
                if (preg_match("/^\d+13$/i", $AyersAccount->account_no)) {
                    $AyersImportData['client_acc_ae_code'] = $Client->ViewIntroducer->ae_code_13;
                } elseif (preg_match("/^\d+08$/i", $AyersAccount->account_no)) {
                    $AyersImportData['client_acc_ae_code'] = $Client->ViewIntroducer->ae_code_08;
                }
                $AyersImportData['RESIDENCE'] = $this->RESIDENCE[$Client->nationality];
                $AyersImportData['PLACE_OF_BIRTH'] = $this->PLACE_OF_BIRTH[$Client->nationality];
                $AyersImportDatas[] = $AyersImportData;
            }
        }
        return view('excel.AyersImportData', [
            'Headers' => $this->Headers,
            'AyersImportDatas' => $AyersImportDatas,
        ]);
    }
}
