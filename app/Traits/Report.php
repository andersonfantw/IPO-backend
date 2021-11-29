<?php

namespace App\Traits;

use App\Client;
use PDF;

trait Report
{
    use Image;

    public function test()
    {
        $Client = Client::where('uuid', 'bb4b9191-9076-46ac-bb14-218bf11b9251')->first();
        $this->AccountOpeningForm($Client);
        // return $this->CyssDmaAgreement();
    }

    public function CyssDmaAgreement()
    {
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        $data = [
            'logo' => $logo,
        ];
        // return view('pdf.CyssDmaAgreement', $data);
        $pdf = PDF::loadView('pdf.CyssDmaAgreement', $data);
        return $pdf->stream('CyssDmaAgreement.pdf');
        // $pdf->save(storage_path("app/upload/$Client->uuid/CyssDmaAgreement.pdf"));
    }

    public function AccountOpeningForm(Client $Client)
    {
        set_time_limit(100);
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        if (is_object($Client->ClientFinancialStatus)) {
            $fund_source = json_decode($Client->ClientFinancialStatus->fund_source, true);
        } else {
            return;
        }
        if (is_object($Client->ClientBusinessType)) {
            $direct_promotion = json_decode($Client->ClientBusinessType->direct_promotion, true);
        } else {
            return;
        }
        $ClientSignature = $this->imagePathToBase64(storage_path("app/upload/$Client->uuid/signature.png"));
        $ROSignature = $this->imagePathToBase64(storage_path("images/Max.png"));
        $ViewClientQuestionnaire = $Client->ViewClientQuestionnaire;
        if (!is_object($ViewClientQuestionnaire)) {
            return;
        }
        $Nationality = [
            'zh-hk' => '中國香港',
            'zh-cn' => '中國',
            'others' => '台灣',
        ];
        if (!is_object($Client->IDCard)) {
            return;
        }
        if (!is_object($Client->ClientWorkingStatus)) {
            return;
        }
        if (!is_object($Client->ClientInvestmentExperience)) {
            return;
        }
        $BankCard = $Client->ClientBankCards->whereIn('lcid', ['zh-hk', 'others'])->first();
        if (!is_object($BankCard)) {
            return;
        }
        if (is_object($Client->ClientAddressProof)) {
            $FullResidentialAddress = $Client->ClientAddressProof->address_text;
        } else {
            $FullResidentialAddress = $Client->IDCard->idcard_address;
        }
        if ($Client->IDCard->name_en) {
            $ClientNameE = $Client->IDCard->name_en;
        } else {
            $ClientNameE = "{$Client->IDCard->surname} {$Client->IDCard->given_name}";
        }
        $data = [
            'logo' => $logo,
            'AccountNature' => '個人',
            'AccountType' => '證券現金',
            'AccountNo' => null,
            'InternetTradingService' => '是',
            'ClientNameC' => [$Client->IDCard->name_c, null],
            'ClientNameE' => [$ClientNameE, null],
            'ClientSignature' => [$ClientSignature, null],
            'ROSignature' => $ROSignature,
            'Gender' => [$Client->IDCard->gender, null],
            'IDNo' => [$Client->IDCard->idcard_no, null],
            'Nationality' => [$Nationality[$Client->nationality], null],
            'EducationLevel' => [substr($Client->education_level, 0, 1), null],
            'FullResidentialAddress' => [$FullResidentialAddress, null],
            'Tel' => [null, null],
            'Mobile' => [$Client->mobile, null],
            'Fax' => [null, null],
            'Email' => [$Client->email, null],
            'EmploymentStatus' => [$Client->ClientWorkingStatus->working_status, null],
            'EmployerName' => [$Client->ClientWorkingStatus->company_name, null],
            'OfficeTel' => [null, null],
            'OfficeAddress' => [null, null],
            'BusinessNature' => [$Client->ClientWorkingStatus->industry, null],
            'ServiceYears' => [null, null],
            'Position' => [$Client->ClientWorkingStatus->position, null],
            'FundingSource' => [
                [
                    '薪金' => in_array("薪金", $fund_source),
                    '家庭收入' => in_array("家庭收入", $fund_source),
                    '租金收入' => in_array("租金收入", $fund_source),
                    '退休基金' => in_array("退休基金", $fund_source),
                    '營業溢利' => in_array("營業溢利", $fund_source) || in_array("营业溢利", $fund_source),
                    '利息' => in_array("股息/利息", $fund_source),
                    '個人儲蓄' => in_array("個人儲蓄", $fund_source) || in_array("个人储蓄", $fund_source),
                    '投資收入' => in_array("投資收入", $fund_source) || in_array("投资收入", $fund_source),
                    '佣金' => in_array("佣金", $fund_source),
                    '其他' => in_array("其他", $fund_source),
                    '其他收入來源' => in_array("其他", $fund_source) ? $Client->ClientFinancialStatus->other_fund_source : null,
                ],
                [
                    '薪金' => null,
                    '家庭收入' => null,
                    '租金收入' => null,
                    '退休基金' => null,
                    '營業溢利' => null,
                    '利息' => null,
                    '個人儲蓄' => null,
                    '投資收入' => null,
                    '佣金' => null,
                    '其他' => null,
                    '其他收入來源' => null,
                ],
            ],
            'AnnualIncome' => [$Client->ClientFinancialStatus->annual_income, null],
            'NetAsset' => [$Client->ClientFinancialStatus->net_assets, null],
            'InvestmentObjective' => [$Client->ClientInvestmentExperience->investment_objective, null],
            'InvestmentObjectiveOther' => [$Client->ClientInvestmentExperience->other_investment_objective, null],
            'InvestmentExperience' => [
                [
                    '股票' => substr($Client->ClientInvestmentExperience->stock, 0, 1),
                    '衍生認股證' => substr($Client->ClientInvestmentExperience->derivative_warrants, 0, 1),
                    '牛熊證' => substr($Client->ClientInvestmentExperience->cbbc, 0, 1),
                    '期貨及期權' => substr($Client->ClientInvestmentExperience->futures_and_options, 0, 1),
                    '債券/基金' => substr($Client->ClientInvestmentExperience->bonds_funds, 0, 1),
                    '其他' => $Client->ClientInvestmentExperience->other_investment_experience,
                ],
                [
                    '股票' => null,
                    '衍生認股證' => null,
                    '牛熊證' => null,
                    '期貨及期權' => null,
                    '債券/基金' => null,
                    '其他' => null,
                ],
            ],
            'DerivativesProductKnowledge' => [
                [
                    $ViewClientQuestionnaire->a9 === '是',
                    $ViewClientQuestionnaire->a10 === '是',
                    $ViewClientQuestionnaire->a11 === '是',
                    $ViewClientQuestionnaire->a12 === '是',
                ],
                [null, null, null, null],
            ],
            'AssessmentResult' => [
                $ViewClientQuestionnaire->a13 === '否',
                null,
            ],
            'Disclosure' => [
                [
                    '1' => [
                        'Option' => false,
                        'EmployerNameAndRegNo' => null,
                    ],
                    '2' => [
                        'Option' => false,
                        'NameOfEmployee/AccountExecutive' => null,
                        'Relationship' => null,
                    ],
                    '3' => [
                        'Option' => false,
                        'CompanyName' => null,
                        'StockCode' => null,
                    ],
                    '4i' => [
                        'Option' => null,
                        'NameOfTheSpouse' => null,
                        'AccountNo' => null,
                    ],
                    '4ii' => [
                        'Option' => null,
                        'CompanyName' => null,
                        'AccountNo' => null,
                    ],
                ],
                [
                    '1' => [
                        'Option' => null,
                        'EmployerNameAndRegNo' => null,
                    ],
                    '2' => [
                        'Option' => null,
                        'NameOfEmployee/AccountExecutive' => null,
                        'Relationship' => null,
                    ],
                    '3' => [
                        'Option' => null,
                        'CompanyName' => null,
                        'StockCode' => null,
                    ],
                    '4i' => [
                        'Option' => null,
                        'NameOfTheSpouse' => null,
                        'AccountNo' => null,
                    ],
                    '4ii' => [
                        'Option' => null,
                        'CompanyName' => null,
                        'AccountNo' => null,
                    ],
                ],
            ],
            'C1' => [
                '是' => true,
                'Name' => null,
                'DateOfBirth' => null,
                'IDNo' => null,
                'Nationality' => null,
                'Address' => null,
            ],
            'C2' => [
                '是' => true,
                'Name' => null,
                'DateOfBirth' => null,
                'IDNo' => null,
                'Nationality' => null,
            ],
            'D' => [
                '銀行名稱' => $BankCard->bank_name,
                '貨幣' => $BankCard->currency,
                '帳戶號碼' => "{$BankCard->bank_code}{$BankCard->branch_code}{$BankCard->account_no}",
                '請註明' => null,
                '銀行帳戶持有人名稱' => $Client->IDCard->name_c,
                '地區及銀行代碼' => null,
            ],
            'E' => [
                '通訊方式' => '電郵',
                '備註' => null,
            ],
            'F' => [
                '直接促銷' => $Client->ClientBusinessType->agree_direct_promotion,
                '任何途徑' => false,
                '快遞' => in_array('快遞', $direct_promotion) || in_array('快递', $direct_promotion),
                '郵件' => in_array('郵件', $direct_promotion) || in_array('邮件', $direct_promotion),
                '短訊' => in_array('短訊', $direct_promotion) || in_array('短讯', $direct_promotion),
                '電話' => in_array('電話', $direct_promotion) || in_array('电话', $direct_promotion),
            ],
            'Date' => [
                date("Y-m-d"),
                null,
            ],
            'J' => [
                '閣下是美國公民' => [false, false],
                '納稅人識別號碼' => [null, null],
                '閣下是綠卡持有者' => [false, false],
            ],
            'Witness' => [
                'Signature' => null,
                'Name' => null,
                'Profession' => null,
                'Date' => null,
            ],
            'LicensedPerson' => [
                'Signature' => '經CA認證',
                'Name' => null,
                'CENo' => null,
                'Date' => null,
            ],
            'ResponsibleOfficer' => [
                'Signature' => $ROSignature,
                'Name' => '洪榮聰',
                'Date' => null,
            ],
            'DocumentReviewedBy' => [
                'Name' => null,
                'Signature' => null,
                'Date' => null,
            ],
        ];
        // return view('pdf.AccountOpeningForm', $data);
        $pdf = PDF::loadView('pdf.AccountOpeningForm', $data);
        // return $pdf->stream('AccountOpeningForm.pdf');
        $pdf->save(storage_path("app/upload/$Client->uuid/AccountOpeningForm.pdf"));
    }

    // private function getAnswerGrade(String $answer)
    // {
    //     return substr($answer, 0, 1);
    // }

    /**
     * Author: Anderson
     * @param $str
     * @return string|string[]
     */
    public function fixChineseWrapInPDF($str)
    {
        $s = '';
        for ($i = 0; $i < mb_strlen($str); $i++) {
            $s .= mb_substr($str, $i, 1) . ' ';
        }
        return str_replace(["\r\n", "\n", "\r"], "<br />", $s);
    }

    public function StylingImages()
    {
        return [
            'logo' => $this->imagePathToBase64(public_path('images/logo.png')),
            'watermark' => $this->imagePathToBase64(public_path('images/ccyss-removebg-preview.png')),
        ];
    }
}
