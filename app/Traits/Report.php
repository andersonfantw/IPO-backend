<?php
namespace App\Traits;

use DB;
use PDF;

trait Report
{
    use ImageToBase64;

    public function AccountOpeningForm()
    {
        $logo = $this->imagePathToBase64(public_path('images/logo.png'));
        $data = [
            'logo' => $logo,
        ];
        return view('pdf.AccountOpeningForm', $data);
        // $pdf = PDF::loadView('pdf.AccountOpeningForm', $data);
        // return $pdf->stream('AccountOpeningForm.pdf');
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
