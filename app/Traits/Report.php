<?php
namespace App\Traits;

use App\Client;
use DB;
use PDF;

trait Report
{
    use ImageToBase64;

    public function AccountOpeningForm(Client $Client)
    {
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        $data = [
            'logo' => $logo,
            'AccountNature' => '個人',
            'AccountType' => '證券現金',
            'AccountNo' => null,
            'InternetTradingService' => '是',
            'ClientNameC' => [
                $Client->IDCard->name_c,
                null,
            ],
            'ClientNameE' => ['???', '???'],
            'Gender' => ['男', '女'],
            'IDNo' => ['???', '???'],
            'Nationality' => ['???', '???'],
            'EducationLevel' => ['大學或以上', '中學'],
            'FullResidentialAddress' => ['???', '???'],
            'Tel' => ['???', '???'],
            'Mobile' => ['???', '???'],
            'Fax' => ['???', '???'],
            'Email' => ['???', '???'],
            'EmploymentStatus' => ['自僱', '受僱'],
            'EmployerName' => ['???', '???'],
            'OfficeTel' => ['???', '???'],
            'OfficeAddress' => ['???', '???'],
            'BusinessNature' => ['???', '???'],
            'ServiceYears' => ['???', '???'],
            'Position' => ['???', '???'],
            'FundingSource' => [
                [
                    '薪金' => true,
                    '家庭收入' => true,
                    '租金收入' => true,
                    '退休基金' => true,
                    '營業溢利' => true,
                    '利息' => true,
                    '個人儲蓄' => true,
                    '投資收入' => true,
                    '佣金' => true,
                    '租金收入' => true,
                    '其他' => '???',
                ],
                [
                    '薪金' => true,
                    '家庭收入' => true,
                    '租金收入' => true,
                    '退休基金' => true,
                    '營業溢利' => true,
                    '利息' => true,
                    '個人儲蓄' => true,
                    '投資收入' => true,
                    '佣金' => true,
                    '租金收入' => true,
                    '其他' => '???',
                ],
            ],
            'AnnualIncome' => ['>1200000', '<100001'],
            'NetAsset' => ['>1200000', '<100001'],
            'InvestmentObjective' => ['股息收入', '資本增值'],
            'InvestmentObjectiveOther' => ['???', '???'],
            'InvestmentExperience' => [
                [
                    '股票' => '超過十年',
                    '衍生認股證' => '超過十年',
                    '牛熊證' => '超過十年',
                    '期貨及期權' => '超過十年',
                    '債券/基金' => '超過十年',
                    '其他' => '超過十年',
                ],
                [
                    '股票' => '三至五年',
                    '衍生認股證' => '三至五年',
                    '牛熊證' => '三至五年',
                    '期貨及期權' => '三至五年',
                    '債券/基金' => '三至五年',
                    '其他' => '三至五年',
                ],
            ],
            'DerivativesProductKnowledge' => [
                [true, true, true],
                [true, true, true],
            ],
            'AssessmentResult' => [
                '沒有認識',
                '有認識',
            ],
            'Disclosure' => [
                [
                    '1' => [
                        'Option' => true,
                        'EmployerNameAndRegNo' => '???',
                    ],
                    '2' => [
                        'Option' => true,
                        'NameOfEmployee/AccountExecutive' => '???',
                        'Relationship' => '???',
                    ],
                    '3' => [
                        'Option' => true,
                        'CompanyName' => '???',
                        'StockCode' => '???',
                    ],
                    '4i' => [
                        'Option' => true,
                        'NameOfTheSpouse' => '???',
                        'AccountNo' => '???',
                    ],
                    '4ii' => [
                        'Option' => true,
                        'CompanyName' => '???',
                        'AccountNo' => '???',
                    ],
                ],
                [
                    '1' => [
                        'Option' => true,
                        'EmployerNameAndRegNo' => '???',
                    ],
                    '2' => [
                        'Option' => true,
                        'NameOfEmployee/AccountExecutive' => '???',
                        'Relationship' => '???',
                    ],
                    '3' => [
                        'Option' => true,
                        'CompanyName' => '???',
                        'StockCode' => '???',
                    ],
                    '4i' => [
                        'Option' => true,
                        'NameOfTheSpouse' => '???',
                        'AccountNo' => '???',
                    ],
                    '4ii' => [
                        'Option' => true,
                        'CompanyName' => '???',
                        'AccountNo' => '???',
                    ],
                ],
            ],
            'C1' => [
                '是' => false,
                'Name' => '???',
                'DateOfBirth' => '???',
                'IDNo' => '???',
                'Nationality' => '???',
                'Address' => '???',
            ],
            'C2' => [
                '是' => false,
                'Name' => '???',
                'DateOfBirth' => '???',
                'IDNo' => '???',
                'Nationality' => '???',
            ],
            'D' => [
                '銀行名稱' => '???',
                '貨幣' => '其他貨幣',
                '帳戶號碼' => '???',
                '請註明' => '???',
                '銀行帳戶持有人名稱' => '???',
                '地區及銀行代碼' => '???',
            ],
            'E' => [
                '通訊方式' => '電郵',
                '備註' => '???',
            ],
            'F' => [
                '直接促銷' => true,
                '任何途徑' => true,
                '電郵' => true,
                '郵件' => true,
                '短訊' => true,
                '電話' => true,
            ],
            'Date' => [
                '???',
                '???',
            ],
            'J' => [
                '閣下是美國公民' => [false, false],
                '納稅人識別號碼' => ['???', '???'],
                '閣下是綠卡持有者' => [false, false],
            ],
            'Witness' => [
                'Signature' => null,
                'Name' => '???',
                'Profession' => '???',
                'Date' => '???',
            ],
            'LicensedPerson' => [
                'Signature' => '經CA認證',
                'Name' => '???',
                'CENo' => '???',
                'Date' => '???',
            ],
            'ResponsibleOfficer' => [
                'Signature' => null,
                'Name' => '???',
                'Date' => '???',
            ],
            'DocumentReviewedBy' => [
                'Name' => '???',
                'Signature' => '???',
                'Date' => '???',
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
        return $pdf->stream('AccountOpeningForm.pdf');
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
