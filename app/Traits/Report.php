<?php
namespace App\Traits;

use App\Client;
use DB;
use PDF;

trait Report
{
    use ImageToBase64;

    public function test()
    {
        // $Client = Client::where('uuid', '8c0dba01-9340-4690-971d-3659c6cbde0e')->first();
        // $this->AccountOpeningForm($Client);
        return $this->CyssDmaAgreement();
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
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        $fund_source = json_decode($Client->clientFinancialStatus->fund_source, true);
        $direct_promotion = json_decode($Client->clientBusinessType->direct_promotion, true);
        $ClientSignature = $this->imagePathToBase64(storage_path("app/upload/$Client->uuid/signature.jpg"));
        $Nationality = [
            'zh-hk' => '中國香港',
            'zh-cn' => '中國',
        ];
        $data = [
            'logo' => $logo,
            'AccountNature' => '個人',
            'AccountType' => '證券現金',
            'AccountNo' => null,
            'InternetTradingService' => '是',
            'ClientNameC' => [$Client->IDCard->name_c, null],
            'ClientNameE' => [$Client->ViewClientIDCard->name_en, null],
            'ClientSignature' => [$ClientSignature, null],
            'Gender' => [$Client->IDCard->gender, null],
            'IDNo' => [$Client->IDCard->idcard_no, null],
            'Nationality' => [$Nationality[$Client->nationality], null],
            'EducationLevel' => [substr($Client->education_level, 0, 1), null],
            'FullResidentialAddress' => [$Client->ViewClientIDCard->address_line1, null],
            'Tel' => [null, null],
            'Mobile' => [$Client->mobile, null],
            'Fax' => [null, null],
            'Email' => [$Client->email, null],
            'EmploymentStatus' => [$Client->clientWorkingStatus->working_status, null],
            'EmployerName' => [$Client->clientWorkingStatus->company_name, null],
            'OfficeTel' => [null, null],
            'OfficeAddress' => [null, null],
            'BusinessNature' => [$Client->clientWorkingStatus->industry, null],
            'ServiceYears' => [null, null],
            'Position' => [$Client->clientWorkingStatus->position, null],
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
                    '其他收入來源' => in_array("其他", $fund_source) ? $Client->clientFinancialStatus->other_fund_source : null,
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
            'AnnualIncome' => [$Client->clientFinancialStatus->annual_income, null],
            'NetAsset' => [$Client->clientFinancialStatus->net_assets, null],
            'InvestmentObjective' => [$Client->clientInvestmentExperience->investment_objective, null],
            'InvestmentObjectiveOther' => [$Client->clientInvestmentExperience->other_investment_objective, null],
            'InvestmentExperience' => [
                [
                    '股票' => substr($Client->clientInvestmentExperience->stock, 0, 1),
                    '衍生認股證' => substr($Client->clientInvestmentExperience->derivative_warrants, 0, 1),
                    '牛熊證' => substr($Client->clientInvestmentExperience->cbbc, 0, 1),
                    '期貨及期權' => substr($Client->clientInvestmentExperience->futures_and_options, 0, 1),
                    '債券/基金' => substr($Client->clientInvestmentExperience->bonds_funds, 0, 1),
                    '其他' => $Client->clientInvestmentExperience->other_investment_experience,
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
                    $Client->ViewClientQuestionnaire->a9 === '是',
                    $Client->ViewClientQuestionnaire->a10 === '是',
                    $Client->ViewClientQuestionnaire->a11 === '是',
                    $Client->ViewClientQuestionnaire->a12 === '是',
                ],
                [null, null, null, null],
            ],
            'AssessmentResult' => [
                $Client->ViewClientQuestionnaire->a13 === '否',
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
                '銀行名稱' => null,
                '貨幣' => null,
                '帳戶號碼' => null,
                '請註明' => null,
                '銀行帳戶持有人名稱' => $Client->IDCard->name_c,
                '地區及銀行代碼' => null,
            ],
            'E' => [
                '通訊方式' => '電郵',
                '備註' => null,
            ],
            'F' => [
                '直接促銷' => $Client->clientBusinessType->agree_direct_promotion,
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
                'Signature' => null,
                'Name' => null,
                'Date' => null,
            ],
            'DocumentReviewedBy' => [
                'Name' => null,
                'Signature' => null,
                'Date' => null,
            ],
            // 'yes' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/yes.png')),
            // 'image_11_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/11.jpg')),
            // 'image_a2_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-2.jpg')),
            // 'image_a3_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-3.jpg')),
            // 'image_a4_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-4.jpg')),
            // 'image_a5_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-5.jpg')),
            // 'image_a6_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-6.jpg')),
            // 'image_a7_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-7.jpg')),
            // 'image_a8_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-8.jpg')),
            // 'image_a9_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-9.jpg')),
            // 'image_a10_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-10.jpg')),
            // 'image_a11_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-11.jpg')),
            // 'image_a12_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-12.jpg')),
            // 'image_a13_1_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-13-1.jpg')),
            // 'image_a14_jpg' => $this->imagePathToBase64(storage_path('images/AccountOpeningForm/a-14.jpg')),
        ];
        // return view('pdf.AccountOpeningForm', $data);
        $pdf = PDF::loadView('pdf.AccountOpeningForm', $data);
        // return $pdf->stream('AccountOpeningForm.pdf');
        $pdf->save(storage_path("app/upload/$Client->uuid/AccountOpeningForm.pdf"));
    }

    public function Chinayss()
    {

        $sql = "select y_user.clnId,
        ifnull(u.relation,-1) relation,
        ifnull(u.isInternal,-1) isInternal,
        ui.educationLevel as education,
        un.status,
        hk.birthday,
        hk.sex hkSex,
        hk.chequeReceipt,
        hk.inAccountType,
        hk.inMoney,
        hk.inBankName,
        hk.inDeposit,
        hk.inDepositOther,
        hk.inMoneyTime,
        year(now())- year(substring(ui.idCard,7,8)) idCardAge,
        l.promotion,
        l.promotionChannel,
        u.tuijiancode,
        CONCAT(ui.surname,ui.name) eName,
        f.age,
        f.ageText,
        f.educationLevel1,
        f.educationLevelText,
        f.investmentExperience,
        f.investmentExperienceText,
        f.onceInvestment,
        f.onceInvestmentText,
        f.investmentYear,
        f.investmentYearText,
        f.target,
        f.targetText,
        f.attitude,
        f.attitudeText,
        f.accept,
        f.acceptText,
        f.incomePercentage,
        f.incomePercentageText,
        f.expenditure,
        f.expenditureText,
        f.monthMoney,
        f.monthMoneyText,
        f.train,
        f.trainText,
        f.handsOnBackground,
        f.handsOnBackgroundText,
        f.handsOnBackgroundName,
        f.handsOnBackgroundDept,
        f.derivativeProducts,
        f.derivativeProductsText,
        f.derivativeProductsTF,
        f.derivativeProductsTFText,
        f.notDerivativeProducts,
        f.disclosure5Account,
        f.disclosure5Company,
        f.disclosure5,
        f.disclosure4,
        f.disclosure4Spouse,
        f.disclosure4Account,
        f.disclosure1,
        f.disclosure1Detail,
        f.disclosure2,
        f.disclosure2Name,
        f.disclosure2Relationship,
        f.disclosure3,
        f.disclosure3Detail,
        f.knowledgeAssessment,
        f.investmentExperienceOther,
        f.bondsFunds,
        f.futuresOptions,
        f.shareCertificate,
        f.derivativeWarrant,
        f.oxBearSyndrome,
        f.investmentTarget,
        f.investmentTargetOther,
        f.annualIncome,
        f.netAssetValue,
        f.sourceFunds,
        f.assetItems,
        ui.*,
        DATE_FORMAT(l.addTime,'%%Y年%%m月%%d日') lAddTime,
        l.businessType,
        u.uuid uid,
        u.type,
        u.mobile,
        u.email,
        IF (MOD(SUBSTRING(ui.idCard,17,1),2),'男','女') AS sex,
        l.uploadAutograph,
        l.onlineAutograph,
        f.riskResultConfirm,
        f.scoreArtificial,
        f.score
        from t_userinfo ui
        right join t_user u
        on u.id = ui.userId
        left join t_livingbodyverity l
        on l.userId = ui.userId
        left join t_financialstate f
        on f.userId = ui.userId
        left join t_userinfo_hk hk
        on hk.userId = ui.userId
        left join t_unaudited un
        on un.userId = ui.uuid
        left join y_user
        on y_user.idNo = ui.idCard
        where ui.idCard = ?";
        $UserInfo = DB::connection('mysql2')->select($sql, ['450922199210264613']);
        if (count($UserInfo) > 0) {
            $UserInfo = $UserInfo[0];
        }
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        $ROSign = $this->imagePathToBase64(storage_path('images/Max.png'));
        $data = [
            'logo' => $logo,
            'ClientAccountNo' => $UserInfo->clnId,
            'Q1Score' => $this->getAnswerGrade($UserInfo->ageText) . " - $UserInfo->age",
            'Q2Score' => $this->getAnswerGrade($UserInfo->educationLevelText) . " - $UserInfo->educationLevel1",
            'Q3Score' => $this->getAnswerGrade($UserInfo->investmentExperienceText) . " - $UserInfo->investmentExperience",
            'TotalScore' => $UserInfo->score,
            'Over65' => $UserInfo->idCardAge >= 65,
            'Agree' => true,
            'ClientAgreedInvestmentOrientation' => '$ClientAgreedInvestmentOrientation',
            'ClientSign' => $ROSign,
            'ClientName' => $UserInfo->realName,
            'ClientDate' => '$ClientDate',
            'LicensedPersonSign' => $ROSign,
            'ROSign' => $ROSign,
            'LicensedPersonName' => '$LicensedPersonName',
            'ROName' => '$ROName',
            'LicensedPersonDate' => '$LicensedPersonDate',
            'RODate' => '$RODate',
            'LicensedPersonCENo' => '$LicensedPersonCENo',
            'ROCENo' => '$ROCENo',
        ];
        $pdf = PDF::loadView('pdf.Chinayss', $data);
        return $pdf->stream('Chinayss.pdf');
    }

    private function getAnswerGrade(String $answer)
    {
        return substr($answer, 0, 1);
    }
}
