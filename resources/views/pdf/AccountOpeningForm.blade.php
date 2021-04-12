<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
    .border {
        border: 1px solid black;
        border-collapse: collapse;
    }

    table {
        width: 100%;
        border-spacing: 0;
    }

    td {
        padding: 0;
    }

    .page-break {
        page-break-after: always;
    }

    .normal-font {
        font-size: 75%;
    }

</style>

<table style="margin-bottom: 100px;width: 100%;">
    <tr>
        <td>
            <img style="width:400px" src="{{ $logo }}" />
        </td>
        <td>
            <div style="text-align: right;font-size: 70%;">6/F., 9 Des Voeux Road West, Sheung Wan, Hong Kong.</div>
            <div style="text-align: right;font-size: 70%;">香港上環德輔道西9號6樓</div>
            <div style="text-align: right;font-size: 70%;">Tel.電話：(852) 2626 0778</div>
            <div style="text-align: right;font-size: 70%;">Fax傳真：(852) 2111 1052</div>
        </td>
    </tr>
</table>


<p class="normal-font">China Yinsheng International Securities Limited ("CYSS") 中國銀盛國際證券有限公司("中國銀盛")
    <br />(中央編號 CE No. : ADJ147)
</p>
<p class="normal-font">
    (如適用請加"✔" Please"✔" as appropriate)
</p>
<table class="border normal-font">
    <tr>
        <td style="text-align: center;background-color:#AED6F1;" class="border">
            <div>ACCOUNT OPENING FORM 開戶表格</div>
            <div>(For Individual 個人/Joint Account 聯名)</div>
        </td>
    </tr>
    <tr>
        <td style="padding: 0" class="border">
            <table>
                <tr>
                    <td style="width: 33%">
                        <strong>Account Nature 帳戶形式</strong>
                    </td>
                    <td style="width: 33%">
                        <input type="checkbox" @if ($AccountNature === '個人') checked @endif> Individual 個人
                    </td>
                    <td style="width: 33%">
                        <input type="checkbox" @if ($AccountNature === '聯名') checked @endif> Joint 聯名
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <div>Account Type 帳戶類別</div>
            <table>
                <tr>
                    <td style="width: 50%">
                        <input type="checkbox" @if ($AccountType === '證券現金') checked @endif>Securities Cash 證券現金
                        <div>(Account No. 帳戶號碼) @if ($AccountType === '證券現金')
                                {{ $AccountNo }} @endif
                        </div>
                    </td>
                    <td style="width: 50%">
                        <input type="checkbox" @if ($AccountType === '證券保證金') checked @endif>Securities Margin 證券保證金
                        <div>(Account No. 帳戶號碼) @if ($AccountType === '證券保證金')
                                {{ $AccountNo }} @endif
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <strong>Internet Trading Service 網上交易服務</strong>
                    </td>
                    <td style="width: 25%">
                        <input type="checkbox" @if ($InternetTradingService === '是') checked @endif> Yes 是
                    </td>
                    <td style="width: 25%">
                        <input type="checkbox" @if ($InternetTradingService === '否') checked @endif> No 否
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="border normal-font">
    <tr>
        <td class="border" style="text-align: center;background-color:#AED6F1;">
            <div>
                <strong>A. Individual/Primary Joint Account Holder</strong>
            </div>
            <div>
                <strong>個人/聯名帳戶主要持有人</strong>
            </div>
        </td>
    </tr>
    <tr>
        <td class="border">
            <strong>1. Client Information 客戶資料</strong>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 50%">
                        客戶姓名: {{ $ClientNameC[0] }}
                        @if ($Gender[0] === '男')
                            先生
                        @else
                            女士
                        @endif
                    </td>
                    <td style="width: 50%">
                        Client Name:
                        @if ($Gender[0] === '男')
                            Mr.
                        @else
                            Ms.
                        @endif
                        {{ $ClientNameE[0] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>
                            I.D. Card/Passport No.
                        </div>
                        <div>
                            身份證/護照號碼
                        </div>
                    </td>
                    <td style="width: 25%">
                        {{ $IDNo[0] }}
                    </td>
                    <td style="width: 25%">
                        <div>
                            Nationality
                        </div>
                        <div>
                            國籍
                        </div>
                    </td>
                    <td style="width: 25%">
                        {{ $Nationality[0] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <div>
                Education Level 教育程度
            </div>
            <table>
                <tr>
                    <td style="width: 50%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EducationLevel[0] === 'A' || $EducationLevel[0] === 'B') checked @endif> University or above 大學或以上
                    </td>
                    <td style="width: 50%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EducationLevel[0] === 'D') checked @endif> Secondary 中學
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EducationLevel[0] === 'E') checked @endif> Primary school or below 小學或以下
                    </td>
                    <td style="width: 50%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EducationLevel[0] === 'B' || $EducationLevel[0] === 'C') checked @endif> Others 其他
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>Full Residential Address</div>
                        <div>住宅地址</div>
                    </td>
                    <td>
                        {{ $FullResidentialAddress[0] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>Tel No.</div>
                        <div>住宅電話號碼</div>
                    </td>
                    <td style="width: 25%">
                        {{ $Tel[0] }}
                    </td>
                    <td style="width: 25%">
                        <div>Mobile No.</div>
                        <div>手提電話號碼</div>
                    </td>
                    <td style="width: 25%">
                        {{ $Mobile[0] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>Fax No.</div>
                        <div>傳真號碼</div>
                    </td>
                    <td style="width: 25%">
                        {{ $Fax[0] }}
                    </td>
                    <td style="width: 25%">
                        <div>E-mail Address</div>
                        <div>電郵地址</div>
                    </td>
                    <td style="width: 25%">
                        {{ $Email[0] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
{{-- <div class="page-break"></div> --}}
<div class="border normal-font">
    2. Employment Status 工作狀況
</div>
<table class="normal-font">
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[0] === '單位任職' || $EmploymentStatus[0] === '单位任职') checked @endif> Employed 受僱
                    </td>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[0] === '自主創業' || $EmploymentStatus[0] === '自主创业') checked @endif> Self-Employed 自僱
                    </td>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[0] === '退休') checked @endif> Retired 退休
                    </td>
                </tr>
                <tr>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[0] === '家庭主婦' || $EmploymentStatus[0] === '家庭主妇') checked @endif> Housewife 家庭主婦
                    </td>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[0] === '學生' || $EmploymentStatus[0] === '学生') checked @endif> Others 其他
                    </td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>
                            Name(s) of Employer
                        </div>
                        <div>
                            僱主名稱
                        </div>
                    </td>
                    <td style="width: 25%">
                        {{ $EmployerName[0] }}
                    </td>
                    <td style="width: 25%">
                        <div>
                            Office Tel No.
                        </div>
                        <div>
                            公司電話號碼
                        </div>
                    </td>
                    <td style="width: 25%">
                        {{ $OfficeTel[0] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 50%">
                        <div>
                            Office Address
                        </div>
                        <div>
                            公司地址
                        </div>
                    </td>
                    <td style="width: 50%">
                        {{ $OfficeAddress[0] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td class="border" style="width: 50%">
                        <div>
                            Nature of Business 業務性質
                        </div>
                        <div>
                            {{ $BusinessNature[0] }}
                        </div>
                    </td>
                    <td class="border" style="width: 25%">
                        <div>
                            Years of Service 服務年資
                        </div>
                        <div>
                            {{ $ServiceYears[0] }}
                        </div>
                    </td>
                    <td class="border" style="width: 25%">
                        <div>
                            Position 職位
                        </div>
                        <div>
                            {{ $Position[0] }}
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="page-break"></div>
<div class="border normal-font">
    3. Financial Situation 財政狀況
</div>
<table class="normal-font">
    <tr>
        <td class="border" style="width: 20%;text-align: center;">
            Source of Funding 資金來源
        </td>
        <td class="border" style="width: 20%;text-align: center;">
            <div>
                Annual Income (HKD)
            </div>
            <div>
                每年收入(港元)
            </div>
        </td>
        <td class="border" style="width: 20%;text-align: center;">
            <div>
                Asset Items
            </div>
            <div>
                資產項目
            </div>
        </td>
        <td class="border" style="width: 20%;text-align: center;">
            <div>
                Total Net Asset Value (HKD)
            </div>
            <div>
                資產淨值(港元)
            </div>
        </td>
    </tr>
    <tr>
        <td class="border" style="width: 20%;vertical-align: text-top;">
            <p>
                <input type="checkbox" @if ($FundingSource[0]['薪金']) checked @endif> Salary 薪金
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['家庭收入']) checked @endif> Family Income 家庭收入
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['租金收入']) checked @endif> Rental Income 租金收入
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['退休基金']) checked @endif> Retirement Fund 退休基金
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['營業溢利']) checked @endif> Business Profit 營業溢利
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['利息']) checked @endif> Dividend 股息/Interest 利息
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['個人儲蓄']) checked @endif> Personal Savings 個人儲蓄
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['投資收入']) checked @endif> Investment Income 投資收入
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['佣金']) checked @endif> Commission 佣金
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['租金收入']) checked @endif> Rental Income 租金收入
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[0]['其他']) checked @endif> Others 其他: {{ $FundingSource[0]['其他收入來源'] }}
            </p>
        </td>
        <td class="border" style="width: 20%;vertical-align: text-top;">
            <p>
                <input type="checkbox" @if ($AnnualIncome[0] === '<100001') checked @endif> &lt; 100,001
            </p>
            <p>
                <input type="checkbox" @if ($AnnualIncome[0] === '100001–360000') checked @endif> 100,001 - 360,000
            </p>
            <p>
                <input type="checkbox" @if ($AnnualIncome[0] === '360001–600000') checked @endif> 360,001 - 600,000
            </p>
            <p>
                <input type="checkbox" @if ($AnnualIncome[0] === '600001-1200000') checked @endif> 600,001 - 1,200,000
            </p>
            <p>
                <input type="checkbox" @if ($AnnualIncome[0] === '>1200000') checked @endif> &gt; 1,200,000
            </p>
        </td>
        <td class="border" style="width: 20%;vertical-align: text-top;">
            <p>
                <input type="checkbox"> Land and Property 房地產
            </p>
            <p>
                <input type="checkbox"> Cash 現金/Deposit 存款
            </p>
            <p>
                <input type="checkbox"> Listed securities 上市證券
            </p>
            <p>
                <input type="checkbox"> Vehicle(s) 車輛
            </p>
            <p>
                <input type="checkbox"> Others 其他:
            </p>
        </td>
        <td class="border" style="width: 20%;vertical-align: text-top;">
            <p>
                <input type="checkbox" @if ($NetAsset[0] === '<100001') checked @endif> &lt; 100,001
            </p>
            <p>
                <input type="checkbox" @if ($NetAsset[0] === '100001–360000') checked @endif> 100,001 - 360,000
            </p>
            <p>
                <input type="checkbox" @if ($NetAsset[0] === '360001–600000') checked @endif> 360,001 - 600,000
            </p>
            <p>
                <input type="checkbox" @if ($NetAsset[0] === '600001-1200000') checked @endif> 600,001 - 1,200,000
            </p>
            <p>
                <input type="checkbox" @if ($NetAsset[0] === '>1200000') checked @endif> &gt; 1,200,000
            </p>
        </td>
    </tr>
</table>
{{-- <div class="page-break"></div> --}}
<div class="border normal-font">
    4. Investment Experience &amp; Derivative Products Knowledge 投資經驗及衍生產品認識
</div>
<div class="border normal-font">
    <p>
        (i) Investment Objective(s) (please select one) 投資目標 (請選擇一項)
    </p>
    <table>
        <tr>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[0] === '股息收入') checked @endif> Dividend Income 股息收入
            </td>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[0] === '資本增值' || $InvestmentObjective[0] === '资本增值') checked @endif> Capital Appreciation 資本增值
            </td>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[0] === '投機' || $InvestmentObjective[0] === '投机') checked @endif> Speculation 投機
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[0] === '對沖' || $InvestmentObjective[0] === '对冲') checked @endif> Hedging 對沖
            </td>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[0] === '其他') checked @endif> Others 其他︰{{ $InvestmentObjectiveOther[0] }}
            </td>
            <td>
            </td>
        </tr>
    </table>
    <p>
        (ii) Investment Experience 投資經驗
    </p>
    <p>
        Stock 股票
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['股票'] === 'E') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['股票'] === 'D') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['股票'] === 'C') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['股票'] === 'B') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['股票'] === 'A') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Derivative Warrants 衍生認股證
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['衍生認股證'] === 'E') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['衍生認股證'] === 'D') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['衍生認股證'] === 'C') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['衍生認股證'] === 'B') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['衍生認股證'] === 'A') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Callable Bull/Bear Contracts (CBBC) 牛熊證
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['牛熊證'] === 'E') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['牛熊證'] === 'D') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['牛熊證'] === 'C') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['牛熊證'] === 'B') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['牛熊證'] === 'A') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Futures &amp; Options 期貨及期權
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['期貨及期權'] === 'E') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['期貨及期權'] === 'D') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['期貨及期權'] === 'C') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['期貨及期權'] === 'B') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['期貨及期權'] === 'A') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Bonds/Funds 債券/基金
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['債券/基金'] === 'E') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['債券/基金'] === 'D') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['債券/基金'] === 'C') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['債券/基金'] === 'B') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[0]['債券/基金'] === 'A') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Others 其他：{{ $InvestmentExperience[0]['其他'] }}
    </p>
    <div>
        (iii) Assessment of Client's Knowledge of structured and/or
        derivatives product(s)
    </div>
    <div>
        客戶對結構性及/或衍生工具產品的認識評估：
    </div>
    <p></p>
    <div>
        <input type="checkbox" @if ($DerivativesProductKnowledge[0][0]) checked @endif> The Client has attended trainings or courses in relation
        to structured and/or derivative product(s)
        客戶曾接受有關結構性及/或衍生工具産品的培訓或修讀相關課程
    </div>
    <p></p>
    <div>
        <input type="checkbox" @if ($DerivativesProductKnowledge[0][1]) checked @endif> The Client's current or previous work experience is
        related to structured and/or derivative product(s)
        客戶現時或之前的工作經驗與結構性及/或衍生工具産品有關
    </div>
    <p></p>
    <div>
        <input type="checkbox" @if ($DerivativesProductKnowledge[0][2]) checked @endif> The Client has executed 5 or more transactions relating
        to structured and/or derivative product(s) in past 3 years
        客戶在過去3年内曾執行過5宗或以上有關結構性及/或衍生工具産品的交易
    </div>
    <p></p>
    <div>
        <input type="checkbox" @if ($DerivativesProductKnowledge[0][3]) checked @endif> The client have previous experience in investing in derivative products (such as
        CBBCs/stock options/derivative warrants/stock-linked products, etc.)
        客戶以往曾否有投資衍生産品的經驗(如牛熊證/股票期權/衍生認股證/股票挂鈎産品等)
    </div>
    <p>
        For clients do not have any of the above mentioned
        knowledge and experience, such clients will be considered
        as without knowledge of structured and/or derivatives
        product(s). Before trading in structured and/or derivative
        product(s), the attention of the Client is drawn to the
        risks associated with structured and/or derivative
        product(s) (as described in Client Agreement – Appendix 2
        Risk Disclosure Statement and Disclaimers).
        如客戶沒有以上任何一項經驗及認識，客戶將被視作沒有結構性及/或衍生工具產品認識。
        在客戶買賣結構性及/或衍生工具產品之前，客戶需要留意衍生工具產品交易有關之風險
        (客戶協議書 - 附錄2 風險披露及免責聲明所述)。
    </p>
    <p>
        *Structured and/ or Derivative product(s) includes, but not
        limited to, Callable Bull/Bear Contracts, Derivative
        Warrants, Equity Linked Instruments/Notes, Exchange Traded
        Funds, Futures and Options and Stock Options, etc.
        結構性及/或衍生工具產品包括(但不限於)牛熊證、衍生認股證、股票掛鈎產品、交易所買
        賣換股債券、交易所買賣基金、期貨及期權與及股票期權等。
    </p>
</div>
{{-- <div class="page-break"></div> --}}
<table class="normal-font">
    <tr>
        <td class="border" style="text-align: center">
            <div>
                ASSESSMENT RESULT 評估結果
            </div>
            <div>
                (FOR OFFICAL USE ONLY 只供本公司使用)
            </div>
        </td>
        <td class="border">
            <div>
                The above Client is characterized as a client 上述客戶被歸類為：
            </div>
            <div>
                <input type="checkbox" @if (!$AssessmentResult[0]) checked @endif> without knowledge of structured and/ or derivatives
                product(s) 「對結構性及/或衍生工具產品沒有認識」
            </div>
            <div>
                <input type="checkbox" @if ($AssessmentResult[0]) checked @endif> with knowledge of structured and/ or derivatives
                product(s) 「對結構性及/或衍生工具產品有認識」
            </div>
        </td>
    </tr>
</table>
<div class="page-break"></div>
<div class="border normal-font">
    5. Disclosure 披露
</div>
<div class="border normal-font">
    <div>
        1. Are you an employee/agent of a Licensed Corporation or
        Registered Institution of Hong Kong Securities and Futures
        Commission? 閣下是否香港證監會持牌或註冊人士的僱員/代理人?
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[0]['1']['Option']) checked @endif> No 否
            </td>
            <td style="vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[0]['1']['Option']) checked @endif> Yes, please provide details
                是，請提供詳情：{{ $Disclosure[0]['1']['EmployerNameAndRegNo'] }}
                <div>(Employer's Name and Reg. No. 僱主姓名及註冊編號)</div>
            </td>
        </tr>
    </table>
    <p></p>
    <div>
        2. Are you an employee/account executive or the relative of employee/account executive of CYSS?
        閣下是否中國銀盛的僱員/營業經紀或該人士的親屬 ?
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[0]['2']['Option']) checked @endif> No 否
            </td>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[0]['2']['Option']) checked @endif> Yes 是
            </td>
            <td>
                <div>Name of Employee/Account Executive
                    僱員/營業經紀姓名：{{ $Disclosure[0]['2']['NameOfEmployee/AccountExecutive'] }}</div>
                <div>Relationship 關係：{{ $Disclosure[0]['2']['Relationship'] }}</div>
            </td>
        </tr>
    </table>
    <p></p>
    <div>
        3. Are you a substantial shareholder*, a senior officer or
        director of any (listed) company whose shares are traded on
        any exchange or market? (For Securities Account only)
        閣下是否任何其股份在交易所或市場買賣的(上市)公司之主要股東*、高級人員或董事? (只適用於證券帳戶)
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[0]['3']['Option']) checked @endif> No 否
            </td>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[0]['3']['Option']) checked @endif> Yes 是
            </td>
            <td>
                <div>Company Name 公司名稱：{{ $Disclosure[0]['3']['CompanyName'] }}</div>
                <div>Stock Code 上市編號：{{ $Disclosure[0]['3']['StockCode'] }}</div>
            </td>
        </tr>
    </table>
    <p>
        * "substantial shareholder" means, in relation to a
        company, a person who is entitled to exercise, or control
        the exercise of, 10% or more of the voting power at any
        general meeting of that company. 「主要股東」指，就一間公司而言，任何人士其於該公司之任何股東大會有權行使，
        或可控制行使，10%或以上之投票權。
    </p>
    <p>
        4. For Securities Margin Accounts Only 只適用於證券保證金帳戶:
    </p>
    <p>
        (i) Is your spouse a margin client of CYSS?
        閣下的配偶是否中國銀盛的證券保證金客戶 ?
    </p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[0]['4i']['Option']) checked @endif> No 否
            </td>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[0]['4i']['Option']) checked @endif> Yes 是
            </td>
            <td>
                <div>Name of the Spouse 配偶姓名：{{ $Disclosure[0]['4i']['NameOfTheSpouse'] }}</div>
                <div>Account No. 帳戶號碼：{{ $Disclosure[0]['4i']['AccountNo'] }}</div>
            </td>
        </tr>
    </table>
    <p>
        (ii) Do you alone or jointly with your spouse control 35%
        or more of the voting rights of any corporate margin client
        of CYSS? 閣下是否單獨或與配偶共同控制中國銀盛的任何證券保證金公司客戶35%或以上的表決權 ?
    </p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[0]['4ii']['Option']) checked @endif> No 否
            </td>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[0]['4ii']['Option']) checked @endif> Yes 是
            </td>
            <td>
                <div>Company Name 公司名稱：{{ $Disclosure[0]['4ii']['CompanyName'] }}</div>
                <div>Account No. 帳戶號碼：{{ $Disclosure[0]['4ii']['AccountNo'] }}</div>
            </td>
        </tr>
    </table>
    <p>
    </p>
</div>
<table class="normal-font">
    <tr>
        <td class="border" style="text-align: center;background-color:#AED6F1;">
            <div>
                B. Secondary Joint Account Holder
            </div>
            <div>
                聯名帳戶第二持有人
            </div>
        </td>
    </tr>
    <tr>
        <td class="border">
            1. Client Information 客戶資料
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 50%">
                        客戶姓名: {{ $ClientNameC[1] }}
                        @if ($Gender[1] === '男')
                            先生
                        @else
                            女士
                        @endif
                    </td>
                    <td style="width: 50%">
                        Client Name:
                        @if ($Gender[1] === '男')
                            Mr.
                        @else
                            Ms.
                        @endif
                        {{ $ClientNameE[1] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>
                            I.D. Card/Passport No.
                        </div>
                        <div>
                            身份證/護照號碼
                        </div>
                    </td>
                    <td style="width: 25%">
                        {{ $IDNo[1] }}
                    </td>
                    <td style="width: 25%">
                        <div>
                            Nationality
                        </div>
                        <div>
                            國籍
                        </div>
                    </td>
                    <td style="width: 25%">
                        {{ $Nationality[1] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <div>
                Education Level 教育程度
            </div>
            <table>
                <tr>
                    <td style="width: 50%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EducationLevel[1] === '大學或以上') checked @endif> University or above 大學或以上
                    </td>
                    <td style="width: 50%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EducationLevel[1] === '中學') checked @endif> Secondary 中學
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EducationLevel[1] === '小學或以下') checked @endif> Primary school or below 小學或以下
                    </td>
                    <td style="width: 50%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EducationLevel[1] === '其他') checked @endif> Others 其他
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 50%">
                        <div>Full Residential Address</div>
                        <div>住宅地址</div>
                    </td>
                    <td style="width: 50%">
                        {{ $FullResidentialAddress[1] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>Tel No.</div>
                        <div>住宅電話號碼</div>
                    </td>
                    <td style="width: 25%">
                        {{ $Tel[1] }}
                    </td>
                    <td style="width: 25%">
                        <div>Mobile No.</div>
                        <div>手提電話號碼</div>
                    </td>
                    <td style="width: 25%">
                        {{ $Mobile[1] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>Fax No.</div>
                        <div>傳真號碼</div>
                    </td>
                    <td style="width: 25%">
                        {{ $Fax[1] }}
                    </td>
                    <td style="width: 25%">
                        <div>E-mail Address</div>
                        <div>電郵地址</div>
                    </td>
                    <td style="width: 25%">
                        {{ $Email[1] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="border normal-font">
    2. Employment Status 工作狀況
</div>
<table class="normal-font">
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[1] === '受僱') checked @endif> Employed 受僱
                    </td>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[1] === '自僱') checked @endif> Self-Employed 自僱
                    </td>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[1] === '退休') checked @endif> Retired 退休
                    </td>
                </tr>
                <tr>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[1] === '家庭主婦') checked @endif> Housewife 家庭主婦
                    </td>
                    <td style="width: 33%;vertical-align: text-top;">
                        <input type="checkbox" @if ($EmploymentStatus[1] === '其他') checked @endif> Others 其他
                    </td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 25%">
                        <div>
                            Name(s) of Employer
                        </div>
                        <div>
                            僱主名稱
                        </div>
                    </td>
                    <td style="width: 25%">
                        {{ $EmployerName[1] }}
                    </td>
                    <td style="width: 25%">
                        <div>
                            Office Tel No.
                        </div>
                        <div>
                            公司電話號碼
                        </div>
                    </td>
                    <td style="width: 25%">
                        {{ $OfficeTel[1] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="border">
            <table>
                <tr>
                    <td style="width: 50%">
                        <div>
                            Office Address
                        </div>
                        <div>
                            公司地址
                        </div>
                    </td>
                    <td style="width: 50%">
                        {{ $OfficeAddress[1] }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td class="border" style="width: 50%">
                        <div>
                            Nature of Business 業務性質
                        </div>
                        <div>
                            {{ $BusinessNature[1] }}
                        </div>
                    </td>
                    <td class="border" style="width: 25%">
                        <div>
                            Years of Service 服務年資
                        </div>
                        <div>
                            {{ $ServiceYears[1] }}
                        </div>
                    </td>
                    <td class="border" style="width: 25%">
                        <div>
                            Position 職位
                        </div>
                        <div>
                            {{ $Position[1] }}
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="page-break"></div>
<div class="border normal-font">
    3. Financial Situation 財政狀況
</div>
<table class="normal-font">
    <tr>
        <td class="border" style="width: 20%;text-align: center;">
            Source of Funding 資金來源
        </td>
        <td class="border" style="width: 20%;text-align: center;">
            <div>
                Annual Income (HKD)
            </div>
            <div>
                每年收入(港元)
            </div>
        </td>
        <td class="border" style="width: 20%;text-align: center;">
            <div>
                Asset Items
            </div>
            <div>
                資產項目
            </div>
        </td>
        <td class="border" style="width: 20%;text-align: center;">
            <div>
                Total Net Asset Value (HKD)
            </div>
            <div>
                資產淨值(港元)
            </div>
        </td>
    </tr>
    <tr>
        <td class="border" style="width: 20%;vertical-align: text-top;">
            <p>
                <input type="checkbox" @if ($FundingSource[1]['薪金']) checked @endif> Salary 薪金
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['家庭收入']) checked @endif> Family Income 家庭收入
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['租金收入']) checked @endif> Rental Income 租金收入
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['退休基金']) checked @endif> Retirement Fund 退休基金
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['營業溢利']) checked @endif> Business Profit 營業溢利
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['利息']) checked @endif> Dividend 股息/Interest 利息
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['個人儲蓄']) checked @endif> Personal Savings 個人儲蓄
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['投資收入']) checked @endif> Investment Income 投資收入
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['佣金']) checked @endif> Commission 佣金
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['租金收入']) checked @endif> Rental Income 租金收入
            </p>
            <p>
                <input type="checkbox" @if ($FundingSource[1]['其他']) checked @endif> Others 其他: {{ $FundingSource[1]['其他收入來源'] }}
            </p>
        </td>
        <td class="border" style="width: 20%;vertical-align: text-top;">
            <p>
                <input type="checkbox" @if ($AnnualIncome[1] === '<100001') checked @endif> &lt; 100,001
            </p>
            <p>
                <input type="checkbox" @if ($AnnualIncome[1] === '100001–360000') checked @endif> 100,001 - 360,000
            </p>
            <p>
                <input type="checkbox" @if ($AnnualIncome[1] === '360001–600000') checked @endif> 360,001 - 600,000
            </p>
            <p>
                <input type="checkbox" @if ($AnnualIncome[1] === '600001-1200000') checked @endif> 600,001 - 1,200,000
            </p>
            <p>
                <input type="checkbox" @if ($AnnualIncome[1] === '>1200000') checked @endif> &gt; 1,200,000
            </p>
        </td>
        <td class="border" style="width: 20%;vertical-align: text-top;">
            <p>
                <input type="checkbox"> Land and Property 房地產
            </p>
            <p>
                <input type="checkbox"> Cash 現金/Deposit 存款
            </p>
            <p>
                <input type="checkbox"> Listed securities 上市證券
            </p>
            <p>
                <input type="checkbox"> Vehicle(s) 車輛
            </p>
            <p>
                <input type="checkbox"> Others 其他:
            </p>
        </td>
        <td class="border" style="width: 20%;vertical-align: text-top;">
            <p>
                <input type="checkbox" @if ($NetAsset[1] === '<100001') checked @endif> &lt; 100,001
            </p>
            <p>
                <input type="checkbox" @if ($NetAsset[1] === '100001–360000') checked @endif> 100,001 - 360,000
            </p>
            <p>
                <input type="checkbox" @if ($NetAsset[1] === '360001–600000') checked @endif> 360,001 - 600,000
            </p>
            <p>
                <input type="checkbox" @if ($NetAsset[1] === '600001-1200000') checked @endif> 600,001 - 1,200,000
            </p>
            <p>
                <input type="checkbox" @if ($NetAsset[1] === '>1200000') checked @endif> &gt; 1,200,000
            </p>
        </td>
    </tr>
</table>
{{-- <div class="page-break"></div> --}}
<div class="border normal-font">
    4. Investment Experience &amp; Derivative Products Knowledge 投資經驗及衍生產品認識
</div>
<div class="border normal-font">
    <p>
        (i) Investment Objective(s) (please select one) 投資目標 (請選擇一項)
    </p>
    <table>
        <tr>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[1] === '股息收入') checked @endif> Dividend Income 股息收入
            </td>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[1] === '資本增值') checked @endif> Capital Appreciation 資本增值
            </td>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[1] === '投機') checked @endif> Speculation 投機
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[1] === '對沖') checked @endif> Hedging 對沖
            </td>
            <td>
                <input type="checkbox" @if ($InvestmentObjective[1] === '其他') checked @endif> Others 其他︰{{ $InvestmentObjectiveOther[1] }}
            </td>
            <td>
            </td>
        </tr>
    </table>
    <p>
        (ii) Investment Experience 投資經驗
    </p>
    <p>
        Stock 股票
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['股票'] === '沒有') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['股票'] === '少於三年') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['股票'] === '三至五年') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['股票'] === '五至十年') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['股票'] === '超過十年') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Derivative Warrants 衍生認股證
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['衍生認股證'] === '沒有') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['衍生認股證'] === '少於三年') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['衍生認股證'] === '三至五年') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['衍生認股證'] === '五至十年') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['衍生認股證'] === '超過十年') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Callable Bull/Bear Contracts (CBBC) 牛熊證
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['牛熊證'] === '沒有') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['牛熊證'] === '少於三年') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['牛熊證'] === '三至五年') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['牛熊證'] === '五至十年') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['牛熊證'] === '超過十年') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Futures &amp; Options 期貨及期權
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['期貨及期權'] === '沒有') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['期貨及期權'] === '少於三年') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['期貨及期權'] === '三至五年') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['期貨及期權'] === '五至十年') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['期貨及期權'] === '超過十年') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Bonds/Funds 債券/基金
    </p>
    <table>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['債券/基金'] === '沒有') checked @endif> Nil 沒有或少於1年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['債券/基金'] === '少於三年') checked @endif> Less than 3 years 少於三年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['債券/基金'] === '三至五年') checked @endif> 3-5 years 三至五年
            </td>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['債券/基金'] === '五至十年') checked @endif> 5-10 years 五至十年
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <input type="checkbox" @if ($InvestmentExperience[1]['債券/基金'] === '超過十年') checked @endif> Over 10 years 超過十年
            </td>
            <td></td>
        </tr>
    </table>
    <p>
        Others 其他：{{ $InvestmentExperience[1]['其他'] }}
    </p>
    <div>
        (iii) Assessment of Client's Knowledge of structured and/or
        derivatives product(s)
    </div>
    <div>
        客戶對結構性及/或衍生工具產品的認識評估：
    </div>
    <p></p>
    <div>
        <input type="checkbox" @if ($DerivativesProductKnowledge[1][0]) checked @endif> The Client has attended trainings or courses in relation
        to structured and/or derivative product(s)
        客戶曾接受有關結構性及/或衍生工具產品的培訓或相關課程
    </div>
    <p></p>
    <div>
        <input type="checkbox" @if ($DerivativesProductKnowledge[1][1]) checked @endif> The Client's current or previous work experience is
        related to structured and/or derivative product(s)
        客戶現時或之前的工作經驗與結構性及/或衍生工具產品有關
    </div>
    <p></p>
    <div>
        <input type="checkbox" @if ($DerivativesProductKnowledge[1][2]) checked @endif> The Client has executed 5 or more transactions relating
        to structured and/or derivative product(s) in past 3 years 客戶在過去3年內曾執行過5宗或以上有關結構性及/或衍生工具產品的交易
    </div>
    <p>
        For clients do not have any of the above mentioned
        knowledge and experience, such clients will be considered
        as without knowledge of structured and/or derivatives
        product(s). Before trading in structured and/or derivative
        product(s), the attention of the Client is drawn to the
        risks associated with structured and/or derivative
        product(s) (as described in Client Agreement – Appendix 2
        Risk Disclosure Statement and Disclaimers).
        如客戶沒有以上任何一項經驗及認識，客戶將被視作沒有結構性及/或衍生工具產品認識。
        在客戶買賣結構性及/或衍生工具產品之前，客戶需要留意衍生工具產品交易有關之風險
        (客戶協議書 - 附錄2 風險披露及免責聲明所述)。
    </p>
    <p>
        *Structured and/ or Derivative product(s) includes, but not
        limited to, Callable Bull/Bear Contracts, Derivative
        Warrants, Equity Linked Instruments/Notes, Exchange Traded
        Funds, Futures and Options and Stock Options, etc.
        結構性及/或衍生工具產品包括(但不限於)牛熊證、衍生認股證、股票掛鈎產品、交易所買
        賣換股債券、交易所買賣基金、期貨及期權與及股票期權等。
    </p>
</div>
<table class="normal-font">
    <tr>
        <td class="border" style="text-align: center">
            <div>
                ASSESSMENT RESULT 評估結果
            </div>
            <div>
                (FOR OFFICAL USE ONLY 只供本公司使用)
            </div>
        </td>
        <td class="border">
            <div>
                The above Client is characterized as a client 上述客戶被歸類為：
            </div>
            <div>
                <input type="checkbox" @if ($AssessmentResult[1] === '沒有認識') checked @endif> without knowledge of structured and/ or derivatives
                product(s) 「對結構性及/或衍生工具產品沒有認識」
            </div>
            <div>
                <input type="checkbox" @if ($AssessmentResult[1] === '有認識') checked @endif> with knowledge of structured and/ or derivatives
                product(s) 「對結構性及/或衍生工具產品有認識」
            </div>
        </td>
    </tr>
</table>
<div class="page-break"></div>
<div class="border normal-font">
    5. Disclosure 披露
</div>
<div class="border normal-font">
    <div>
        1. Are you an employee/agent of a Licensed Corporation or
        Registered Institution of Hong Kong Securities and Futures
        Commission? 閣下是否香港證監會持牌或註冊人士的僱員/代理人?
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[1]['1']['Option']) checked @endif> No 否
            </td>
            <td style="vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[1]['1']['Option']) checked @endif> Yes, please provide details
                是，請提供詳情：{{ $Disclosure[1]['1']['EmployerNameAndRegNo'] }}
                <div>(Employer's Name and Reg. No. 僱主姓名及註冊編號)</div>
            </td>
        </tr>
    </table>
    <p></p>
    <div>
        2. Are you an employee/account executive or the relative of employee/account executive of CYSS?
        閣下是否中國銀盛的僱員/營業經紀或該人士的親屬 ?
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[1]['2']['Option']) checked @endif> No 否
            </td>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[1]['2']['Option']) checked @endif> Yes 是
            </td>
            <td>
                <div>Name of Employee/Account Executive
                    僱員/營業經紀姓名：{{ $Disclosure[1]['2']['NameOfEmployee/AccountExecutive'] }}</div>
                <div>Relationship 關係：{{ $Disclosure[1]['2']['Relationship'] }}</div>
            </td>
        </tr>
    </table>
    <p></p>
    <div>
        3. Are you a substantial shareholder*, a senior officer or
        director of any (listed) company whose shares are traded on
        any exchange or market? (For Securities Account only)
        閣下是否任何其股份在交易所或市場買賣的(上市)公司之主要股東*、高級人員或董事? (只適用於證券帳戶)
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[1]['3']['Option']) checked @endif> No 否
            </td>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[1]['3']['Option']) checked @endif> Yes 是
            </td>
            <td>
                <div>Company Name 公司名稱：{{ $Disclosure[1]['3']['CompanyName'] }}</div>
                <div>Stock Code 上市編號：{{ $Disclosure[1]['3']['StockCode'] }}</div>
            </td>
        </tr>
    </table>
    <p>
        * "substantial shareholder" means, in relation to a
        company, a person who is entitled to exercise, or control
        the exercise of, 10% or more of the voting power at any
        general meeting of that company. 「主要股東」指，就一間公司而言，任何人士其於該公司之任何股東大會有權行使，
        或可控制行使，10%或以上之投票權。
    </p>
    <p>
        4. For Securities Margin Accounts Only 只適用於證券保證金帳戶:
    </p>
    <p>
        (i) Is your spouse a margin client of CYSS?
        閣下的配偶是否中國銀盛的證券保證金客戶 ?
    </p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[1]['4i']['Option']) checked @endif> No 否
            </td>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[1]['4i']['Option']) checked @endif> Yes 是
            </td>
            <td>
                <div>Name of the Spouse 配偶姓名：{{ $Disclosure[1]['4i']['NameOfTheSpouse'] }}</div>
                <div>Account No. 帳戶號碼：{{ $Disclosure[1]['4i']['AccountNo'] }}</div>
            </td>
        </tr>
    </table>
    <p>
        (ii) Do you alone or jointly with your spouse control 35%
        or more of the voting rights of any corporate margin client
        of CYSS? 閣下是否單獨或與配偶共同控制中國銀盛的任何證券保證金公司客戶35%或以上的表決權 ?
    </p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if (!$Disclosure[1]['4ii']['Option']) checked @endif> No 否
            </td>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($Disclosure[1]['4ii']['Option']) checked @endif> Yes 是
            </td>
            <td>
                <div>Company Name 公司名稱：{{ $Disclosure[1]['4ii']['CompanyName'] }}</div>
                <div>Account No. 帳戶號碼：{{ $Disclosure[1]['4ii']['AccountNo'] }}</div>
            </td>
        </tr>
    </table>
    <p>
    </p>
</div>
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>
        C. Ultimate Beneficial Owner(s) of the Account and Ultimate Originator(s) of all Transaction
    </div>
    <div>
        最終權益擁有人及最終戶口交易指示發出者
    </div>
</div>
<div class="border normal-font">
    <div>
        1. Are you (and/or the Secondary Joint Account Holder) the
        ultimate beneficial owner(s) in relation to the Account?
        i.e. Are you acting for your own and not for a third party?
        閣下（及/或聯名帳戶第二持有人）是否此戶口最終權益擁有人？
        即是閣下是否為閣下本身而不是第三者處理戶口？
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($C1['是']) checked @endif> Yes
                是
            </td>
            <td>
                <div>
                    <input type="checkbox" @if (!$C1['是']) checked @endif>
                    No, details of the ultimate beneficial owner(s) is/are 否，戶口最終權益擁有人細節如下：
                </div>
                <div>
                    Name 姓名：{{ $C1['Name'] }}
                </div>
                <div>
                    Date of Birth 出生日期：{{ $C1['DateOfBirth'] }}
                </div>
                <div>
                    Passport/ID No. 護照/身份證號碼：{{ $C1['IDNo'] }}
                </div>
                <div>
                    Nationality 國籍：{{ $C1['Nationality'] }}
                </div>
                <div>
                    Address 地址：{{ $C1['Address'] }}
                </div>
            </td>
        </tr>
    </table>
    <p>
        2. Are you (and/or the Secondary Joint Account Holder)
        ultimately responsible for all transaction instructed?
        閣下（及/或聯名帳戶第二持有人）是否最終戶口交易指示發出者?
    </p>
    <table>
        <tr>
            <td style="width: 20%;vertical-align: text-top;">
                <input type="checkbox" @if ($C2['是']) checked @endif> Yes
                是
            </td>
            <td>
                <div>
                    <input type="checkbox" @if (!$C2['是']) checked @endif>
                    No, details of the ultimate beneficial owner(s) is/are 否，戶口最終權益擁有人細節如下：
                </div>
                <div>
                    Name 姓名：{{ $C2['Name'] }}
                </div>
                <div>
                    Date of Birth 出生日期：{{ $C2['DateOfBirth'] }}
                </div>
                <div>
                    Passport/ID No. 護照/身份證號碼：{{ $C2['IDNo'] }}
                </div>
                <div>
                    Nationality 國籍：{{ $C2['Nationality'] }}
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>
        D. Receiving Bank Account
    </div>
    <div>
        收款銀行戶口
    </div>
</div>
<div class="border normal-font">
    <div>
        Funds will be transferred to the following bank account
        after receiving the Client's fund withdrawal instruction
        在收到閣下的提款指示後，將款項轉到以下戶口：
    </div>
    <p></p>
    <table>
        <tr>
            <td class="border" style="width: 50%;vertical-align: text-top;">
                <div>Name of the Bank 銀行名稱：</div>
                <div>{{ $D['銀行名稱'] }}</div>
            </td>
            <td class="border" style="width: 50%">
                <div>Bank Account Currency/Number 銀行帳戶貨幣/號碼：</div>
                <p>
                    <input type="checkbox" @if ($D['貨幣'] === '港元') checked @endif> HKD 港元 A/C No. 帳戶號碼：@if ($D['貨幣'] === '港元')
                        {{ $D['帳戶號碼'] }} @endif
                </p>
                <p>
                    <input type="checkbox" @if ($D['貨幣'] === '人民幣') checked @endif> RMB 人民幣 A/C No. 帳戶號碼：@if ($D['貨幣'] === '人民幣')
                        {{ $D['帳戶號碼'] }} @endif
                </p>
                <p>
                    <input type="checkbox" @if ($D['貨幣'] === '美元') checked @endif> USD 美元 A/C No. 帳戶號碼：@if ($D['貨幣'] === '美元')
                        {{ $D['帳戶號碼'] }} @endif
                </p>
                <div>
                    <input type="checkbox" @if ($D['貨幣'] === '其他貨幣') checked @endif> Other Currency 其他貨幣
                    <div>Please specify 請註明：@if ($D['貨幣'] === '其他貨幣')
                            {{ $D['請註明'] }} @endif
                    </div>
                    <div>A/C No. 帳戶號碼：@if ($D['貨幣'] === '其他貨幣')
                            {{ $D['帳戶號碼'] }} @endif
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="border">
        Bank Account Holder's Name (name(s) shown on the Client's
        bank statements should match with the name of the
        applicant(s) in this Form)
        銀行帳戶持有人名稱 (須與客戶的銀行結單及此表格上的名稱相符)
        <div>{{ $D['銀行帳戶持有人名稱'] }}</div>
    </div>
    <div class="border">
        For bank accounts outside Hong Kong, please state location
        of the bank account and SWIFT code (if applicable)
        若為香港以外銀行帳戶，請提供地區及銀行代碼 (如適用)
        <div>{{ $D['地區及銀行代碼'] }}</div>
    </div>
</div>
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>
        E. Communication Method
    </div>
    <div>
        通訊方式
    </div>
</div>
<div class="border normal-font">
    <div>
        Please choose the following method for the purpose of the
        Client's receiving confirmations, notices, message,
        statements (if applicable) or otherwise from the Broker:
        請選擇以下方式作為客戶接收本公司發出的確認信、通知書、訊息或帳單 (如適用) 或其他之用：
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 33%;vertical-align: text-top;">
                <input type="checkbox" @if ($E['通訊方式'] === '電郵') checked @endif> By E-mail 電郵
            </td>
            <td style="width: 33%;vertical-align: text-top;">
                <input type="checkbox" @if ($E['通訊方式'] === '郵寄至住宅地址') checked @endif> By Post to Residential Address 郵寄至住宅地址
            </td>
            <td style="width: 33%;vertical-align: text-top;">
                <input type="checkbox" @if ($E['通訊方式'] === '郵寄至通訊地址') checked @endif> By Post to Corresponding Address 郵寄至通訊地址：
            </td>
        </tr>
    </table>
    <p>
        Remarks 備註：{{ $E['備註'] }}
    </p>
</div>
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>
        F. Direct Marketing (Please refer to Personal Information Collection Statement)
    </div>
    <div>
        直接促銷（請參閱個人資料收集聲明）
    </div>
</div>
<div class="border normal-font">
    <div>
        <input type="checkbox" @if ($F['直接促銷']) checked @endif> The
        Client(s) expressly agree that CYSS shall use the
        Client's personal data for direct marketing as stipulated
        in Personal Information Collection Statement, and wish to
        receive any direct marketing materials or messages from
        CYSS via the following channel(s)
        客戶清楚同意中國銀盛將客戶的個人資料根據個人資料收集聲明所載使用於直接促銷，
        並且同意收到中國銀盛經以下途徑發出的任何直接促銷資料或訊息：
    </div>
    <p></p>
    <table>
        <tr>
            <td>
                <input type="checkbox" @if ($F['任何途徑']) checked @endif>
                Any Channel 任何途徑
            </td>
            <td>
                <input type="checkbox" @if ($F['快遞']) checked @endif>
                Express Delivery 快遞
            </td>
            <td>
                <input type="checkbox" @if ($F['郵件']) checked @endif> Mail
                郵件
            </td>
            <td>
                <input type="checkbox" @if ($F['短訊']) checked @endif> SMS
                短訊
            </td>
            <td>
                <input type="checkbox" @if ($F['電話']) checked @endif>
                Phone 電話
            </td>
        </tr>
    </table>
    <p>
        <input type="checkbox" @if (!$F['直接促銷']) checked @endif> The
        Client(s) do not wish CYSS to provide the Client's
        personal data to any other persons for their use in direct
        marketing, whether or not such persons are members of the China Yinsheng (Holding) Limited.
        客戶不欲中國銀盛將客戶的個人資料提供予任何其他人士作直接促銷用途。
    </p>
</div>
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>G. Standing Authority for Client Money and Client Securities</div>
    <div>客戶款項及客戶證券的常設授權</div>
</div>
<div class="border normal-font">
    <div>
        1. Unless otherwise defined, the terms used in this
        Authority shall have the same meanings as in the Securities
        and Futures Ordinance, the Securities and Futures (Client
        Money) Rules, the Securities and Futures (Client
        Securities) Rules, Options Trading Rules of SEHK, Rules of
        SEOCH as amended from time to time.
        除非另有說明，本授權書之名詞與《證券及期貨條例》、《證券及期貨（客戶款項）規則》、
        《證券及期貨（客戶證券）規則》、《聯交所期權交易規則》、《聯交所規則》及《期權結算
        公司規則》不時修訂之定義具有相同意思。
    </div>
    <p>
        2. The Client(s) acknowledge that the Client's assets
        (including Monies) received or held by the licensed or
        registered person outside Hong Kong are subject to the
        applicable laws and regulations of the relevant overseas
        jurisdiction which may be different from the Securities and
        Futures Ordinance (Cap.571) and the rules made thereunder.
        Consequently, such client assets may not enjoy the same
        protection as that conferred on client assets received or
        held in Hong Kong.
        客戶確認持牌人或註冊人在香港以外地方收取或持有的客戶資產，是受到有關海外司法管
        轄區的適用法律及規例所監管的。這些法律及規例與《證券及期貨條例》（第571條）及根據該
        條例制訂的規則可能有所不同。因此，有關客戶資產將可能不會享有賦予在香港收取或持有的客
        戶資產的相同保障。
    </p>
    <p>
        3. The Client(s) hereby agree to indemnity, and to keep
        indemnified, CYSS and/or the Nominated Brokers from and
        against all losses, damages, interests, costs, expenses,
        actions, demands, claims or proceedings of whatsoever
        nature which they (or any of them) may incur, suffer and/or
        sustain as a consequence of any transaction undertaken in
        pursuance of this Authority. This indemnity shall survive
        the revocation of this Authority.
        客戶謹此同意就中國銀盛及／或委任經紀，因執行上述授權而可能產生、蒙受及/或承受一切虧損
        、損失、利息、費用、開支、法律訴訟、付款要求索償等向中國銀盛及/或委任經紀作出賠償，並
        保障中國銀盛及/或委任經紀免受損害。本授權被撤銷後仍繼續生效。
    </p>
    <p>
        4. The Authority under section G shall be valid for a
        period of 12 months from the date of the account opening
        and may be extended from year to year by written notice and
        confirmation issued by CYSS until revocation of this
        Authority. The Client(s) can revoke this Authority by
        sending a 14 days prior notice in writing to CYSS. The
        notice period shall run from the date CYSS has/have
        actually received such written notice. Subject to
        applicable laws, such revocation shall not affect any above
        transfer made prior to such revocation becoming effective.
        本部分(G 部分)的授權將於開戶日期起 12個月內有效及可由中國銀盛發出書面通知及確認而每年續延至本授
        權書被撤銷為止。客戶在給予中國銀盛14日事前通知書便可撤銷本授權書。通知期由中國銀盛確實
        收到該通知書當日起計。在受制於適用法律下，該撤銷將不會影響任何上述於該撤銷生效前已作出
        之資金轉戶。
    </p>
    <p>
        5. The Client(s) acknowledge and agree that this Authority
        shall be deemed to be renewed on a continuing basis without
        the Client's written consent if the Company issues the
        Client a written reminder at least fourteen (14) days prior
        to the expiry date of this Authority, and the Client does
        not object to such deemed renewal before such expiry
        date.
        客戶確認並同意，中國銀盛若在本授權的有效期屆滿前14日之前向客戶發出通知，提醒客戶本授權
        即將屆滿，而客戶沒有在授權屆滿前反對此授權續期，本授權應當作在不需要客戶以書面同意下按
        持續的基準已被續期。
    </p>
    <p>
        6. Standing Authority for Client Securities (applicable to Securities Margin Account only)
        客戶證券常設授權 (適用於證券保證金帳戶)
    </p>
    <p style="margin-left: 20px;">
        a. In respect of the treatment of the Client's securities
        deposited with CYSS as collateral, pursuant to section 148
        of the Securities and Futures Ordinance and the Securities
        and Futures (Client Securities) Rules, the Client hereby
        authorizes CYSS may do any of the following without giving
        the Client's notice: 就有關一切由中國銀盛代表客戶存於中國銀盛處作為抵押品之證券，
        根據&lt;證券及期貨條例&gt;第148條及其下之證券及期貨(客戶證券)規則，客戶謹此授權中
        國銀盛可在無須通知客戶情況下：
    </p>
    <p style="margin-left: 40px;">
        (i) deposit any of the Client's securities with an
        authorized financial institution (as defined in the Banking
        Ordinance (Cap 155 of the Laws of Hong Kong) as collateral
        for financial accommodation provided to CYSS;
        將任何客戶的證券存於認可財務機構 (見《銀行業條例》（香港法例第155章）的定義)，作為
        該機構向中國銀盛提供財務通融之抵押品；
    </p>
    <p style="margin-left: 40px;">
        (ii) apply the securities or securities collateral pursuant
        to a securities borrowing and lending agreement;
        根據證券借貸協議規定使用證券或證券抵押品；
    </p>
    <p style="margin-left: 40px;">
        (iii) deposit the securities collateral with a recognised
        clearing house (as defined in the Securities and Futures
        Ordinance) or an intermediary licensed or registered for
        dealing in securities as collateral for the discharge and
        satisfaction of CYSS's settlement obligations and
        liabilities.將證券抵押品存放於認可結算所（定義見《證券及期貨條例》）或
        其他持牌中介人或獲發牌從事證券交易的中介人，作為解除和清償中國銀盛結算義
        務和責任的抵押品。
    </p>
    <p style="margin-left: 20px;">
        b. The Client acknowledges that this Authority shall not
        affect CYSS's right to dispose of the Client's securities
        in settlement of: 客戶確認本授權書不影響中國銀盛為以下目的而處置客戶的證券的權利：
    </p>
    <p style="margin-left: 40px;">
        (i) the Client's obligation to maintain the Margin (as
        defined in the Margin Client Agreement);
        履行客戶維持保證金的義務(根據&lt;保證金客戶協議書&gt;所作之定義)；
    </p>
    <p style="margin-left: 40px;">
        (ii) any of the Client's liability to settle a transaction
        in securities and/or to repay or discharge the financial
        accommodation provided by CYSS;
        履行客戶就某證券交易進行交收及／或付還或解除由中國銀盛所提供的財務通融的法律責任；
    </p>
    <p style="margin-left: 40px;">
        (iii) any of the Client's liability owed to CYSS for
        dealing in securities which remains outstanding after CYSS
        have disposed of all other assets designated as collateral
        for securing the settlement of that liability.
        履行客戶就證券交易而對中國銀盛負有的法律責任，而該法律責任是指在中國銀盛已將指定
        作為保證履行該法律責任的抵押品的所有其他資產處置後仍未履行的法律責任。
    </p>
    <p style="margin-left: 20px;">
        c. Client(s) confirm that CYSS may refuse to draw on the
        facility granted to me to settle any transaction if
        client(s) do not give any authorization required under any
        pplicable laws, rules or regulations. Client(s) confirm
        that the above authorisations are transferable by CYSS or
        CYSS's assigns.
        客戶確認若客戶未依據任何適用法律、規則或法規的規定授予任何必要授權，則中國銀盛可拒絕
        向客戶提供清償任何交易所需的任何融資。客戶確認上述授權可由中國銀盛或中國銀盛的受讓人
        作出轉讓。
    </p>
    <p style="margin-left: 20px;">
        d. Client(s) understand that if CYSS lends or deposits any
        securities in the Margin Account to a third party, the
        return of such securities may be subject to CYSS
        discharging its obligations to such third party.
        客戶理解若將保證金帳戶中的任何證券出借給第三方或存放在第三方處，則此類證券的歸還將取
        決於中國銀盛對此等第三方所承擔責任的履行情況。
    </p>
    <p>
        7. For Authorisation as to Transfer of Securities (applicable to Foreign Securities) 有關股票調配授權 (適用於外地證券)
    </p>
    <p style="margin-left: 20px;">
        a. In respect of the management of and dealing in the
        Foreign Securities (as defined in the Cash Client's
        Agreement or the Margin Client's Agreement, as the case may
        be) in the Client's Account, the Client hereby give this
        Authority to CYSS in relation to the Client Securities:
        有關客戶賬戶的外地證券（現金客戶協議書或保證金客戶協議書中所介定，視乎具體情況而定）
        之交易及管理，客戶謹此授權中國銀盛處理有關客戶在外地的客戶證券交易事宜：
    </p>
    <p style="margin-left: 40px;">
        (i) the Client hereby authorizes CYSS, in CYSS's sole
        discretion, without having to provide the Client with any
        prior notice or to obtain the prior confirmation and/or
        direction of the Client to deposit the Client's Foreign
        Securities to a licensed securities broker or custodian
        nominated by CYSS ("the Custodian") and to be held by the
        Custodian from time to time.
        客戶謹此授權中國銀盛酌情處理客戶之外地證券以作不時之存放及持有於中國銀盛委任之持牌
        證券經紀或託管人（"託管人"）。
    </p>
    <p style="margin-left: 40px;">
        (ii) this Authority does not cover any consideration the
        Client must pay or be paid for the depositing any of the
        Foreign Securities of the Client. Any such consideration
        must be set out in a separate agreement between the Client
        and CYSS.
        本授權書並不涉及就中國銀盛存放客戶任何外地證券而須支付或收取的任何代價。任何代價均
        須由客戶與中國銀盛另行簽約訂明。
    </p>
    <p style="margin-left: 40px;">
        (iii) until further notice, the Client's Foreign Securities
        in the Account will be carried by the Custodian. In the
        event that the Custodian acts as custodian for the
        securities and other property in relation to Foreign
        Securities in the Account, CYSS or the Custodian through
        CYSS are authorized, subject to Client's instructions, to
        register such securities in its name or the name of CYSS or
        the Custodian or their nominees, or cause such Foreign
        Securities to be registered in the name of or the nominee
        of a recognized depository or clearing organization. The
        Client understands and acknowledges that when CYSS or the
        Custodian holds on Client's behalf the Foreign Securities
        which are callable in part by issuer, such securities will
        be subject to CYSS or its impartial lottery allocation
        system in which the probability of Client's securities
        being selected as called is proportional to the holdings of
        all clients of such securities held in bulk by or for CYSS
        or the Custodian. The Client further understands that CYSS
        or the Custodian will withdraw such securities from any
        depository prior to the first date on which such securities
        may be called unless such depository has adopted an
        impartial lottery system which is applicable to all
        participants. The Client may withdraw uncalled securities
        prior to a partial call subject to compliance with
        applicable margin requirements and the terms of any
        agreements between CYSS or the Custodian and the Client.
        CYSS or the Custodian are authorized to withdraw Foreign
        Securities sold or otherwise disposed of, and to credit
        Client's account with the proceeds thereof or make such
        other disposition thereof as the Client may direct. CYSS or
        the Custodian are further authorized to collect all income
        and other payments which may become due on the Client's
        Foreign Securities, to surrender for payment maturing
        obligations and those called for redemption and to exchange
        certificates in temporary form for like certificates in
        definitive form, or, if the par value of any shares is
        changed, to effect the exchange for new certificates. It is
        understood and agreed by the Client that although CYSS or
        the Custodian will use reasonable efforts to effect the
        authorization set forth in the preceding sentence, CYSS or
        the Custodian will incur no liability for CYSS 's or the
        Custodian's failure to effect the same.
        客戶的外地證券將由託管人所持有，直至另行通知。當託管人為外地證券及其他有關外地證券
        的財產之託管人時，中國銀盛及託管人將被授權，在受管制於客戶指示下，將該等外地證券以
        中國銀盛或託管人或其任命人的名義登記或致使該等外地證券以認可託管或結算機構名義登記
        。客戶明白及確認當中國銀盛或託管人代客持有的外地證券為可部分通知贖回證券，該等證券
        將受制於中國銀盛或其公平的抽籤分配系統，將客戶的證券在中國銀盛或託管人的整體持有中
        分配。客戶再明白中國銀盛或託管人將在該等證券贖回首天前由保管人提取該等證券，除非該
        保管人已採用適用於所有參與者的公平抽籤分配系統。客戶在部分贖回通知前提取未贖回的證
        券，將受制於符合適用的保證金要求及客戶與中國銀盛或託管人的合約條款。中國銀盛或託管
        人被授權提取已沽或其他出售，及將有關出售的得益存入客戶賬戶或其他客戶指定方式處理外
        地證券。中國銀盛或託管人再被授權收集有關客戶的外地證券的所有收入及其他可收的付款，
        可交出證券以取得終期付款及其贖回及將臨時證書交換成正式證書，或如股票面值有變，交換
        新的證書。客戶明白及同意，雖然中國銀盛或託管人將以合理地盡力完成上一句子的授權，中
        國銀盛或託管人將不因為中國銀盛或託管人的失誤負上任何責任。
    </p>
    <p style="margin-left: 40px;">
        (iv) the Client declares, undertakes and warrants that the
        Client has the absolute ownership of the Client's Foreign
        Securities free from all liens, charges and encumbrances
        during the continuance in force of this Authority save and
        except for those stipulated in the Margin Client's
        Agreement, if applicable.
        客戶聲明、承諾及保證在本授權之有效期內客戶是為客戶證券之絕對擁有人及其不會受制於任
        何種類的留置權、抵押或產權負權，在保證金客戶協議書所載除外（如適用）。
    </p>
    <p style="margin-left: 20px;">
        b. This Authority is given to CYSS in consideration of
        CYSS's agreeing to continue to maintain the Securities
        account for the Client.
        此賦予中國銀盛之授權乃鑒於中國銀盛同意繼續維持客戶之證券帳戶
    </p>
    <p style="margin-left: 20px;">
        c. The Client fully understands that a third party may have
        rights to the Client's securities and/or Foreign Securities
        which CYSS must satisfy before the Client's Securities can
        be returned to the Client.
        客戶完全明白客戶的證券及／或外地證券可能受制於第三者之權利，中國銀盛須全數抵償該等權
        利後，方可將客戶的證券退回客戶。
    </p>
    <p>
        8. Standing Authority for Client Money (Applicable to all accounts) 客戶款項常設授權（適用於所有帳戶）：
    </p>
    <p style="margin-left: 20px;">
        a. The Client(s) hereby authorizes CYSS to do any of the following without giving me notice:
        本指示授權中國銀盛在無須向本人發出通知的情況下作出以下任何行動：
    </p>
    <p style="margin-left: 40px;">
        (i) combine or consolidate any or all segregated accounts,
        of any nature whatsoever and either individually or jointly
        with others, maintained by CYSS from time to time and may
        transfer any sum of Monies to and between such segregated
        account(s) to satisfy the clients' obligations or
        liabilities to CYSS, whether such obligations and
        liabilities are actual, contingent, primary or collateral,
        secured or unsecured, or joint or several; and
        組合或合併客戶於本公司所開設及持有任何獨立賬戶，此等組合或合併活動可以個別地或與其
        他賬戶聯合進行，可將該等獨立賬戶內任何數額之款項作出轉移，以解除客戶對中國銀盛內的
        義務或法律責任，不論此等義務和法律責任是確實或突然的，原有或附帶的、有抵押或無抵押
        的、共同或分別的;及
    </p>
    <p style="margin-left: 40px;">
        (ii) interchangeably between any of the said segregated account(s). 從任何上述的獨立賬戶之間來回調動。
    </p>
    <p style="margin-left: 20px;">
        b. This authority is given to CYSS in consideration of its
        agreeing to continue to maintain one or more trading
        account(s) at my choice with this Account Opening Form.
        本授權的授予建基於中國銀盛同意按客戶在本開戶申請表中要求開立的一個或多個交易帳戶開立
        及持續運作該等帳戶。
    </p>
    <p style="margin-left: 20px;">
        c. The Client(s) acknowledge that notwithstanding this
        Authority, CYSS is /are not obliged to make any transfer
        abovementioned in the first paragraph hereof, in particular
        but without prejudice to the generality of the foregoing,
        if such transfer may result into a breach of any provision
        of any agreement made or to be made between CYSS and the
        Client(s) (including without limitation the Agreement).
        客戶確認，儘管有本授權書，中國銀盛並無責任作出任何以上第一段所述之資金轉戶，尤其(但以
        不影響本段前文之一般性規定為大前提下)若該資金轉戶可能導致違反任何客戶與中國銀盛已簽訂
        或將會簽訂之協議書(包括不限於「協議書」)內任何條款。
    </p>
    <p style="margin-left: 20px;">
        d. this Authority is given without prejudice to other
        authorities or rights which CYSS may have in relation to
        dealing in the Monies in the segregated accounts.
        本授權並不損害中國銀盛可享有有關處理該等獨立賬戶內款項的其他授權或權利。
    </p>
    <p style="margin-left: 20px;">
        e. Client(s) acknowledge that their assets (including
        Monies) received or held by the licensed or registered
        person outside Hong Kong are subject to the applicable laws
        and regulations of the relevant overseas jurisdiction which
        may be different from the Securities and Futures Ordinance
        and the rules made thereunder. Consequently, such client
        assets may not enjoy the same protection as that conferred
        on client assets received or held in Hong Kong.
        客戶確認持牌人或註冊人在香港境外代表本人持有或收取的資產（包括款項）均應符合相關海外
        司法管轄區的適用法律法規規定，而該等法律法規或與《證券及期貨條例》及項下規則有所不同
        。因此，此類客戶資產或無法享有在香港境內持有或收取該等客戶資產時所能享有的同等保障。
    </p>
    <p>
        This authority has been fully explained to the Client(s),
        and the Client(s) understand and agree with the contents of
        this authority. 客戶就上述授權書的內容已獲得解釋，並且客戶明白及同意本授權書的內容。
    </p>
</div>
<table class="normal-font" style="background-color: #AED6F1">
    <tr>
        <td class="border" style="vertical-align: text-top">
            <div>
                個人/聯名帳戶主要持有人簽署
            </div>
            <div>
                Signature of Individual/Primary Joint Account Holder
            </div>
            <div style="text-align: center">
                <img style="width: 200px" src="{{ $ClientSignature[0] }}" />
            </div>
        </td>
        <td class="border" style="vertical-align: text-top">
            <div>
                聯名帳戶第二持有人簽署
            </div>
            <div>
                Signature of Secondary Joint Account Holder
            </div>
        </td>
    </tr>
    <tr>
        <td class="border">
            <div>
                Client's Name 客戶姓名：{{ $ClientNameC[0] }}
            </div>
            <div>
                Date 日期：{{ $Date[0] }}
            </div>
        </td>
        <td class="border">
            <div>
                Client's Name 客戶姓名：{{ $ClientNameC[1] }}
            </div>
            <div>
                Date 日期：{{ $Date[1] }}
            </div>
        </td>
    </tr>
</table>
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>
        H. Joint Account Mandate (Applicable to Joint Account Client only)
    </div>
    <div>
        聯名帳戶開戶委託書 (只適用於聯名帳戶之客戶)
    </div>
</div>
<div class="border normal-font">
    <div>
        1. We hereby request and authorise CYSS to open the
        account(s) with CYSS in our joint names and at any time
        hereafter upon the instructions of
        <input type="checkbox"> ANY ONE/<input type="checkbox"> ALL* of us:
    </div>
    <div>
        本人兹聯同請求及授權中國銀盛用本人等聯名在中國銀盛開立買賣帳戶辨理，並得於今後依照本人
        等之中<input type="checkbox">任何一人/<input type="checkbox">全體* 所指示，處理下
        列各項事宜：
    </div>
    <p>
        a. to open such further account or accounts in our joint
        names.代本人等聯名另行開立戶口。
    </p>
    <p>
        b. to honour and pay bills of exchange drafts promissory
        notes or orders for payment drawn accepted or made or to
        accept and act upon receipts for monies overdrawn by us or
        for monies owing by CYSS to us on any account whatsoever or
        any other documents or written instructions of whatsoever
        nature kind or description and to debit the same to our
        joint account or accounts and to carry out any instructions
        in connection with our joint account or accounts
        notwithstanding that any such debiting or carrying out may:
        該聯名戶口所發出之支付憑票或在中國銀盛透支款項之收據或本人等聯名在中國銀盛存款之單據或
        任何其他文件或書面指示照予支帳，並處理一切與各該聯名戶口有關事宜，而該等指示即使引致下
        列情況，仍屬有效：
    </p>
    <p>
        (i) direct a transfer to an account in the individual name
        of any one of us. 由聯名戶口調撥款項轉入本人等任何一人之私人戶口。
    </p>
    <p>
        (ii) require CYSS make payment to any one of us.
        要求中國銀盛付款給予本人等之任何一人。
    </p>
    <p>
        (iii) cause such joint account or accounts to be in debit
        or any debit balance thereon to be increased but without
        prejudice to CYSS's right to refuse to allow any such debit
        balance or increase in debit balance.
        引致各該聯名戶口產生透支或增加透支數額情況，但如有此等情況中國銀盛得保留拒絕透支或增加
        透支數額之權利。
    </p>
    <p>
        and we will be jointly and severally responsible for the
        repayment on demand of any such debit balance and interest
        and of any money that CYSS may from time to time advance to
        us on any joint loan account together with interest
        thereon.
        本人等茲同意個別及聯同負責，一經
        貴公司通知，即當如數將所有透支款項連同應付利息及其他一切由本人等聯名向中國銀盛借到之款
        項連同應付利息一併清償，絕無異議。
    </p>
    <p>
        c. without in any way limiting the foregoing general
        request to make any advance to us by way of loan or advance
        or discount or in any manner howsoever with or without
        security.
        除上列範圍外，中國銀盛亦可以放款、透支、貼現或任何其他方式，不論有抵押或無抵押，給予貸
        款。
    </p>
    <p>
        d. without in any way limiting the foregoing general
        request to deliver any securities deeds boxes and parcels
        and their contents and property of any description held in
        our joint name. 同時亦可移交由本人等聯名寄存中國銀盛之任何證券、契據、包裹或其他財物給予指名人仕收受。
    </p>
    <p>
        2. We authorize CYSS to accept for collection any cheque or
        other documents payable to any one or more of us and to
        credit the proceeds thereof to our joint account or
        accounts even though such cheque or order or document has
        been endorsed by the payee or payees thereof.
        本人等授權中國銀盛，由本人等存入中國銀盛而列明本人等任何一人或多人為受款人之支票，支付
        委託書或其他票據，雖未經受款人背書，仍均可由中國銀盛接受代收，收受後記入本人等聯名戶口
        。
    </p>
    <p>
        3. We authorise CYSS to place to the credit of our joint
        account or accounts all sums of money, interest, dividends
        etc., which CYSS may receive on account of any one or more
        of us or our joint and several account or on our joint
        account.
        本人等授權中國銀盛代本人等個別或聯名收受之一切款項，包括利息、股息等等，均可照數記入本
        人等聯名帳戶內。
    </p>
    <p>
        4. Subject to any claim or objection on the part of the
        Estate Duty Commissioner or any other appropriate
        authority, we authorise CYSS to hold on the death of any
        one of us any credit balance or balances of any account or
        accounts in our joint names and any securities deeds boxes
        and parcels and their contents and property of any
        description held in our joint names to the order of the
        survivors or survivor of us or the executors or
        administrators of the last survivor of us without prejudice
        to any right you may have in respect of such balance or
        balances securities etc. arising out of any lien charge
        pledge set-off counterclaim or otherwise whatsoever or any
        step or any legal proceedings which CYSS may in your
        absolute discretion deem it desirable to take in view of
        any claim by any person other that the survivors or
        survivor of us or the executors or administrators of the
        last survivor of us.
        除香港遺產稅徵收主任或其他政府機關有提出要求或提出反對等情況外，本人等授權中國銀盛可於
        本人等中任何一人身故後，代為保管各該聯名戶口之存款，與及本人等聯名寄存中國銀盛之任何證
        券、契據、包裹或其他財物，而依照生存在世之本人等或唯一生存者之遺產承辨人或管業人之指示
        加以處理，而以不損害中國銀盛對存款、證券等等應有之留置權、抵押權、典質權、比對權，及要
        求或任何其他權利為原則，又除本人等中之生存者或其遺產承辨人或管業人以外，不論何人，如有
        要求享受該存款、證券等等之權益者，中國銀盛亦有斟酌選擇之絕對自由，對該等人士採取任何合
        乎需要之步驟或向法庭提出任何訴訟程序。
    </p>
    <p>
        5. We agree that any liability whatsoever incurred to CYSS
        by us in respect of the foregoing shall be our joint and
        several liability.
        如有因此請求及授權富中國銀盛處理上述事項而致產生債務者，本人等同意個別及共同負責。
    </p>
    <p>
        6. We agree to observe and be bounded by such of CYSS's
        Rules for the time being in force as will be applicable to
        the appropriate nature of each of our accounts provided
        that if there is any conflict between the said Rules on the
        one hand and the foregoing terms and conditions contained
        herein on the other hand the latter shall prevail.
        本人等同意遵守中國銀盛所訂有關而適用於本人等在中國銀盛所開立每一戶口之章則，及接受該等
        章則約束，至於該等章則與本委託書互有抵觸之處，則應以本委託書訂定之條文為準。
    </p>
    <p>
        7. In the absence of contrary written instructions signed
        by all of us the foregoing conditions shall apply to each
        and every account of whatever nature now or hereafter
        opened by CYSS in our joint names.
        上列條文均適用於中國銀盛此次或日後代本人等開立之聯名戶口， 直至本人等以聯名簽署之書面通知取消為止。
    </p>
</div>
<table class="normal-font" style="background-color: #AED6F1">
    <tr>
        <td class="border" style="vertical-align: text-top">
            <div>
                個人/聯名帳戶主要持有人簽署
            </div>
            <div>
                Signature of Individual/ Primary Joint Account Holder
            </div>
        </td>
        <td class="border" style="vertical-align: text-top">
            <div>
                聯名帳戶第二持有人簽署
            </div>
            <div>
                Signature of Secondary Joint Account Holder
            </div>
        </td>
    </tr>
    <tr>
        <td class="border">
            <div>
                Client's Name 客戶姓名：
            </div>
            <div>
                Date 日期：
            </div>
        </td>
        <td class="border">
            <div>
                Client's Name 客戶姓名：
            </div>
            <div>
                Date 日期：
            </div>
        </td>
    </tr>
</table>
<div class="page-break"></div>
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>
        I. Declaration by Client(s)
    </div>
    <div>
        客戶聲明
    </div>
</div>
<div class="border normal-font">
    <div>
        1. The undersigned Client(s) agree to open the above account(s) with CYSS.
        以下簽名之客戶（等）同意與中國銀盛開立上述帳戶。
    </div>
    <p>
        2. The Client(s) have read and understood the provisions of
        the Cash Client's Agreement, Margin Client's Agreement
        and/or Futures Client's Agreement applicable to the type of
        account(s) that the Client(s) agree to open and the
        Client(s) accept to be bound by the
        same.
        客戶（等）已閱讀並明白在現金客戶協議書、保證金客戶協議書中所載
        的適用於客戶所選擇之帳戶類別之一切條款，並接受這些條款的約束。
    </p>
    <p>
        3. The information contained in this Account Opening Form
        is true and accurate. CYSS are entitled to rely fully on
        such information for all purposes, unless CYSS receive
        notice in writing of any change.
        客戶（等）載於開戶表格中的資料是真實和準確的。除非中國銀盛收到資料更
        改的書面通知，中國銀盛有權為任何目的信賴這些資料。
    </p>
    <p>
        4. The Client(s) have received the English and Chinese
        versions of the Cash Client's Agreement, Margin Client's
        Agreement (which including the Electronic Service Agreement
        and Personal Information Collection Statement) documents of
        CYSS.
        客戶（等）已收取了中國銀盛之現金客戶協議書、保證金客戶協議書(包
        括電子服務協議書及個人資料收集聲明)("協議書") 等文件。
    </p>
    <p>
        5. The Client(s) acknowledge that the Risk Disclosure
        Statement (including the relevant risks associated with
        trading of RMB products and Foreign Securities) of the
        Client Agreement - securities account, the Risk Disclosure
        Statement for Using Electronic Trading (if applicable) were
        provided in a language of Client's own choice (English or
        Chinese) and the Client was invited to read the Risk
        Disclosure Statement, to ask questions and take independent
        advice if the client wishes.
        客戶（等）確認已按照客戶選擇的語言(英文或中文)獲得客戶協議書 -
        證券帳戶的風險披露聲明書(包括有關買賣人民幣產品及外地證券所涉及的風險)、
        及使用電子交易之風險披露聲明(如適用)及已獲邀請閱讀該風險披露聲明書，及提
        出問題及徵求獨立的意見(如客戶有此意願)。
    </p>
    <p>
        6. If the Client(s) are characterized as "without knowledge
        of derivatives", the Client(s) further acknowledge that the
        Client(s) have carefully read the relevant risks associated
        with investing in derivative products of Client Agreement -
        Appendix 2 Risk Disclosure Statement and Disclaimers
        (including the relevant risks associated with trading of
        RMB products and exchange-traded derivative products) ; the
        Risk Disclosure Statement for Using Electronic Trading (if
        applicable) and fully understood the relevant risks
        herewith. Although the Client(s) might not have relevant
        derivatives product(s) trading experience, the Client(s)
        may still base on the own independent judgement of the
        Client(s) to request for entering into transaction(s) of
        derivatives product(s) and would take all risks
        associated.
        如客戶（等）被歸類為「對衍生產品沒有認識」，客戶（等）進一步確認已仔細閱讀在
        客戶協議書 -附錄2 風險披露及免責聲明(包括有關買賣人民幣產品及在交易所買賣的
        衍生產品所涉及的風險)，使用電子交易之風險披露聲明(如適用)所列明的有關投資衍
        生產品所涉及的風險，並完全明白其中所述之相關風險。儘管客戶可能並沒有相關衍生
        產品交易經驗，客戶可能基於客戶獨立判斷仍要求進行衍生產品交易。客戶願意承擔所
        有相關衍生產品風險。
    </p>
    <p>
        7. The Client(s) are NOT (1) resident(s) of the United
        States of America ("US") or (2) residents of Canada ("CN"),
        whether for US or CN securities or tax laws or for any
        other purposes. The Client(s) also confirm that the
        Client(s) are not acting as agent on behalf of any US
        resident and/or CN resident. The Client(s) undertake to
        immediately notify CYSS should the Client(s) become or be
        deemed to be (1) resident(s) of the US or (2) resident(s)
        of CN at any future time.
        無論就美國或加拿大的證券或稅務法例或其他方面而言，客戶（等）均並非（1）美國居民或（2）
        加拿大居民。客戶亦確認，客戶（等）並不代表任何美國居民及/或加拿大居民行事。客戶承諾，如
        客戶（等）日後成為或被視作（1）美國居民或
    </p>
    <p>
        （2）加拿大居民，將立即通知中國銀盛。
    </p>
    <p>
        8. The Client(s) acknowledge that the Client(s) have read
        the Personal Information Collection Statement and agreed to
        the terms in it. The Client(s) understand and acknowledge
        that CYSS intends to use the Client's personal data for
        direct marketing and CYSS may not so use the Client's data
        unless CYSS has received my/our consent to such intended
        use. The Client(s) expressly acknowledge, confirm and agree
        that unless the Client(s) decide to opt out the use of the
        Client's personal data for direct marketing as stated in
        Section F or by giving notice to CYSS at any time as
        stipulated in Personal Information Collection Statement,
        CYSS shall use the Client's personal data for direct
        marketing as stipulated in Personal Information Collection
        Statement by whatsoever channels.
        客戶（等）承認已詳閱個人資料收集聲明，並完全同意其條款。客戶（等）明白及承認中國銀盛擬
        把客戶（等）的資料使用於直接促銷及中國銀盛須收到客戶（等）對該資料使用的同意，否則不得
        如此使用該資料。客戶（等）清楚明白、承認及同意除非客戶（等）決定如第F部份所述或根據有
        關個人資料收集聲明所載隨時通知中國銀盛而拒絕該等使用，中國銀盛能將根據個人資料收集聲明
        所載使用客戶（等）的個人資料以任何途徑於直接促銷。
    </p>
    <p>
        9. For Client using the Internet Trading Services:
        適用於使用網上交易服務之客戶：
    </p>
    <p style="margin-left: 20px">
        a. the Client(s) have read and understood the provisions of
        the Internet Trading Agreement as set out in the Cash
        Client's Agreement or Margin Client's Agreement of CYSS and
        the Client(s) accept to be bound by the same.
        客戶（等）已經閱讀並明白在中國銀盛的客戶協議書- 附錄3 電子服務協議的條款，並接受這些條款的約束。
    </p>
    <p style="margin-left: 20px">
        b. CYSS will send the Internet Trading Account No. and
        Password to the Client(s) via "Short Message Service" (SMS)
        and/or email unless otherwise requested by the Client(s) in
        advance. 除非客戶（等）另有要求，中國銀盛將以手提電話短訊及/或電子郵件寄出網上交易帳號及密碼。
    </p>
    <p>
        10. For Foreign Securities Trading : 適用於買賣外地證券：
    </p>
    <p style="margin-left: 20px">
        a. the Client(s) represent, warrant, confirm and undertake
        as follows 客戶（等）陳述、保證、確認和承諾如下：
    </p>
    <p style="margin-left: 40px">
        (i) where the Client trades any securities and futures
        products traded in the U.S., that the Client is not a "U.S.
        Person", which means any one or more of the following (in
        the case of paragraphs (aa)-(cc), unless applicable laws,
        rules and regulations provide that such person is not
        subject to the United States federal income taxation on his
        worldwide income):
        倘若客戶買賣任何在美國交易的證券產品，客戶並非「美國人士」，即指符合下文所述的任何
        一項或多項條件的人士(就第(aa)至(cc)段而言，若根據適用的法律、規則及規例規定該等人
        士毋須就其全球範圍內的入息繳納美國聯邦入息稅，則該等人士並非美國人士)：
    </p>
    <p style="margin-left: 60px">
        (aa) a citizen of the United States 美國公民；
    </p>
    <p style="margin-left: 60px">
        (bb) a person that is not a citizen or national of the
        United States and who meets either the "green card" test or
        the "substantial presence" test under the Internal Revenue
        Code of 1986, as amended, and/or any other applicable laws,
        rules and regulations for the calendar year
        並非美國公民或國民，但已符合《1986
        年國內收入法》(經修訂)和／或任何其他適用的法律、規則及規例規定下的「綠卡」測試或
        在相關日曆年「在境內逗留相當長時間」的測試的人士；
    </p>
    <p style="margin-left: 60px">
        (cc) a person electing to be treated as a tax resident of
        the United States; and 選擇作為美國稅務居民的人士；及
    </p>
    <p style="margin-left: 60px">
        (dd) any other person that is subject to the United States
        federal income taxation on his worldwide income regardless
        of its source, 不論其入息來源，須就其全球範圍內的入息繳納美國聯邦入息稅的任何其他人士，
    </p>
    <p style="margin-left: 60px">
        and that in the event that the Client becomes such a
        person, the Client will notify CYSS immediately and will
        transfer all of his holdings in securities and/or futures
        products traded in the United States within a month of the
        occurrence of the event or any other period as determined
        by CYSS, and the Client acknowledges that in that case all
        the income, proceeds, interest and distribution arising
        from such securities and/or futures products shall be
        subject to the maximum withholding tax rate or any other
        withholding tax rate as determined by CYSS from time to
        time.
        而且，倘若客戶成為「美國人士」，客戶應立即通知中國銀盛，並於該等情況發生後一個月
        內（或中國銀盛決定的任何其他時限內）將其持有的所有在美國交易的證券產品的權益轉讓
        ；客戶確認，在該等情況下，因該等產品產生的所有入息、收益、利息和分派均應按最高的
        預扣稅稅率或中國銀盛不時決定的任何其他預扣稅預扣。
    </p>
    <p style="margin-left: 40px">
        (ii) that the Client is not a director or officer, or
        shareholder who holds 10% or more of the interests in the
        shares of, a company listed on any stock exchange in the
        United States.
        客戶並非在美國任何證券交易所上市的任何公司的董事或行政人員，亦非持有任何此類上市公
        司的百分之十或以上股權的股東。
    </p>
    <p style="margin-left: 20px">
        b. the Client(s) acknowledge that the Points to Note on
        Foreign Securities ("Note") were provided in a language of
        Client's own choice (English or Chinese) and the Client(s)
        has read, understand, and agree to the terms set forth in
        the Note. 客戶（等）確認已按照客戶選擇的語言(英文或中文)獲得投資外地證券開戶須知
        ("須知")，並已詳閱及清楚明白並同意以上須知之內容。
    </p>
    <p>
        11. If there is a discrepancy between English and Chinese
        version of the Account Opening Form, the English version
        shall prevail. 如開戶表格之中英文版本文義有歧義，將以英文版本為準。
    </p>
</div>
<table class="normal-font" style="background-color: #AED6F1">
    <tr>
        <td class="border" style="vertical-align: text-top">
            <div>
                個人/聯名帳戶主要持有人簽署
            </div>
            <div>
                Signature of Individual/Primary Joint Account Holder
            </div>
            <div style="text-align: center">
                <img style="width: 200px" src="{{ $ClientSignature[0] }}" />
            </div>
        </td>
        <td class="border" style="vertical-align: text-top">
            <div>
                聯名帳戶第二持有人簽署
            </div>
            <div>
                Signature of Secondary Joint Account Holder
            </div>
        </td>
    </tr>
    <tr>
        <td class="border">
            <div>
                Client's Name 客戶姓名：{{ $ClientNameC[0] }}
            </div>
            <div>
                Date 日期：{{ $Date[0] }}
            </div>
        </td>
        <td class="border">
            <div>
                Client's Name 客戶姓名：{{ $ClientNameC[1] }}
            </div>
            <div>
                Date 日期：{{ $Date[1] }}
            </div>
        </td>
    </tr>
</table>
{{-- <div class="page-break"></div> --}}
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>
        J. FATCA Self-Certification (Individual Investor)
    </div>
    <div>
        海外帳戶稅收合規法案聲明書（個人投資者）
    </div>
</div>
<div class="border normal-font">
    <div>
        1. Self-certification of U.S. tax residency by Individual Clients 美國稅務居民自我聲明
    </div>
    <p></p>
    <table>
        <tr>
            <td>
            </td>
            <td colspan="2" style="vertical-align: text-top;">
                <div>個人/聯名帳戶主要持有人</div>
                <div>Individual/Primary Joint Account Holder</div>
            </td>
            <td colspan="2" style="vertical-align: text-top;">
                <div>聯名帳戶第二持有人 (如有)</div>
                <div>Secondary Joint Account Holder (If any)</div>
            </td>
        </tr>
        <tr>
            <td>
                <div>(i) Are you a citizen of the United States of America?</div>
                <div>閣下是否美國公民?</div>
            </td>
            <td>
                <input type="checkbox" @if ($J['閣下是美國公民'][0]) checked @endif> Yes 是
            </td>
            <td>
                <input type="checkbox" @if (!$J['閣下是美國公民'][0]) checked @endif> No 否
            </td>
            <td>
                <input type="checkbox" @if ($J['閣下是美國公民'][1]) checked @endif> Yes 是
            </td>
            <td>
                <input type="checkbox" @if (!$J['閣下是美國公民'][1]) checked @endif> No 否
            </td>
        </tr>
    </table>
    <p></p>
    <div>
        If yes, Please provide Taxpayer Identification no.:
    </div>
    <div>
        若是，請提供納稅人識別號碼：@if ($J['閣下是美國公民'][0]) {{ $J['納稅人識別號碼'][0] }} @endif,
        @if ($J['閣下是美國公民'][1]) {{ $J['納稅人識別號碼'][1] }} @endif
    </div>
    <p></p>
    <table>
        <tr>
            <td style="width: 50%">
                <div>
                    (ii) Are you a resident of the United States of America for
                    US federal income tax purposes? (Includes green card
                    holder)
                </div>
                <div>
                    閣下是否美國居民 (包括綠卡持有者)?
                </div>
            </td>
            <td>
                <input type="checkbox" @if ($J['閣下是綠卡持有者'][0]) checked @endif> Yes 是
            </td>
            <td>
                <input type="checkbox" @if (!$J['閣下是綠卡持有者'][0]) checked @endif> No 否
            </td>
            <td>
                <input type="checkbox" @if ($J['閣下是綠卡持有者'][1]) checked @endif> Yes 是
            </td>
            <td>
                <input type="checkbox" @if (!$J['閣下是綠卡持有者'][1]) checked @endif> No 否
            </td>
        </tr>
    </table>
    <p></p>
    <div>
        If yes, Please provide Taxpayer Identification no.:
    </div>
    <div>
        若是，請提供納稅人識別號碼：@if ($J['閣下是綠卡持有者'][0]) {{ $J['納稅人識別號碼'][0] }} @endif,
        @if ($J['閣下是綠卡持有者'][1]) {{ $J['納稅人識別號碼'][1] }} @endif
    </div>
    <p>
        Please certify the status of yourself and sign
        below.請閣下認證自己身份及簽署下方。
    </p>
    <p>
        2. Certification 聲明
    </p>
    <p>
        I/We hereby consent for China Yinsheng International
        Securities Limited to disclose report or share my/our
        relevant information with local and overseas regulators or
        tax authorities where necessary to establish my/our tax
        liability in any jurisdiction. I/We declare that I/We have
        examined the information on this self-certification and to
        the best of my/our knowledge and belief; it is true,
        correct, and complete. I/We will inform your company within
        30 days if any information herein becomes incorrect.
        本人/吾等同意中國銀盛國際證券有限公司可向本地及海外監管機構或稅務機構披露、呈交或提供本
        人/吾等的資料以確立本人/吾等於任何司法管轄區的稅務責任。本人/吾等在此聲明本人/吾等已查
        閱此聲明之內容，並盡本人/吾等所知及確信，聲明內容均屬真實，正確及完整。本人/吾等同意如
        以上聲明有變更，將於30日內通知貴公司。
    </p>
</div>
<table class="normal-font" style="background-color: #AED6F1">
    <tr>
        <td class="border" style="vertical-align: text-top">
            <div>
                個人/聯名帳戶主要持有人簽署
            </div>
            <div>
                Signature of Individual/Primary Joint Account Holder
            </div>
            <div style="text-align: center">
                <img style="width: 200px" src="{{ $ClientSignature[0] }}" />
            </div>
        </td>
        <td class="border" style="vertical-align: text-top">
            <div>
                聯名帳戶第二持有人簽署
            </div>
            <div>
                Signature of Secondary Joint Account Holder
            </div>
        </td>
    </tr>
    <tr>
        <td class="border">
            <div>
                Client's Name 客戶姓名：{{ $ClientNameC[0] }}
            </div>
            <div>
                Date 日期：{{ $Date[0] }}
            </div>
        </td>
        <td class="border">
            <div>
                Client's Name 客戶姓名：{{ $ClientNameC[1] }}
            </div>
            <div>
                Date 日期：{{ $Date[1] }}
            </div>
        </td>
    </tr>
</table>
<div class="border normal-font">
    Witness 見證人
</div>
<div class="border normal-font">
    <p>
        The undersigned hereby certify 以下簽署特此核證如下：
    </p>
    <p>
        (i) the signing of the Agreement by the Client(s); and
        客戶簽署本開戶表格；及
    </p>
    <p>
        (ii) the signing of the related identity documents of the
        Client(s) 見證客戶的有關身份證明文件
    </p>
</div>
<table class="normal-font">
    <tr>
        <td rowspan="3" class="border"
            style="width: 50%;vertical-align: text-top;text-align: center;background-color: #AED6F1;">
            Signature of Witness 見證人簽署
            <div>
                <img style="width: 200px" src="{{ $Witness['Signature'] }}" />
            </div>
        </td>
        <td class="border" style="width: 25%">
            Name of Witness 見證人姓名：
        </td>
        <td class="border" style="width: 25%">
            {{ $Witness['Name'] }}
        </td>
    </tr>
    <tr>
        <td class="border">
            Profession/Title 所屬專業/銜頭：
        </td>
        <td class="border">
            {{ $Witness['Profession'] }}
        </td>
    </tr>
    <tr>
        <td class="border">
            Date 日期：
        </td>
        <td class="border">
            {{ $Witness['Date'] }}
        </td>
    </tr>
</table>
{{-- <div class="page-break"></div> --}}
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>
        K. Approval of Account Opening
    </div>
    <div>
        開戶批核
    </div>
</div>
<div class="border normal-font">
    <p>Declaration by China Yinsheng International Securities Limited Staff 中國銀盛國際證券有限公司職員聲明</p>
</div>
<div class="border normal-font">
    <p>
        I, a licensed or registered person, hereby declare that I
        have provided the above Client with a copy of the Client
        Agreement – Appendix 2 Risk Disclosure Statement and
        Disclaimers (including the relevant risks associated with
        investing in RMB securities and Foreign Securities
        products), and Appendix 3 the Risk Disclosure Statement in
        the Electronic Service Agreement (if applicable) in a
        language of Client's choice (English or Chinese) and
        invited the Client to read the Risk Disclosure Statement
        and ask questions and take independent advice if the client
        wishes. If the Client is characterized as "without
        knowledge of structured and/or derivatives product(s)", I
        further declare that I have explained to the Client the
        relevant risks associated with trading of structured and/or
        derivatives product(s) which as described in Client
        Agreement – Appendix 2 Risk Disclosure Statement and
        Disclaimers and the Client fully understood the relevant
        risks herewith.
    </p>
    <p>
        本人，以持牌人或註冊人身份，確認本人已按照上述客戶選擇的語言(英文或中文)提供客戶協議書- 附錄2
        風險披露及免責聲明(包括有關買賣人民幣產品及外地證券所涉及的風險)及附錄3
        電子服務協議所所涉及的風險(如適用)及提示客戶閱讀有關之風險披露聲明書，亦邀請客戶如有需要
        可以提出問題及徵求獨立的意見。如客戶被歸類為「對結構性及/或衍生產品沒有認識」，本人進一步
        確認已向客戶解釋在客戶協議書-附錄2 風險披露及免責聲明所述的有關購買結構性及/或衍生工具產
        品所涉及的風險，及客戶已完全明白其中所述之相關風險。
    </p>
</div>
{{-- <div class="page-break"></div> --}}
<table class="normal-font">
    <tr>
        <td rowspan="3" class="border"
            style="width: 50%;vertical-align: text-top;text-align: center;background-color: #AED6F1;">
            <div>Signature of licensed person 註冊人簽署</div>
            <h1>{{ $LicensedPerson['Signature'] }}</h1>
        </td>
        <td class="border" style="width: 25%">
            Name of licensed person 註冊人姓名：
        </td>
        <td class="border" style="width: 25%">
            {{ $LicensedPerson['Name'] }}
        </td>
    </tr>
    <tr>
        <td class="border">
            CE No. 中央編號：
        </td>
        <td class="border">
            {{ $LicensedPerson['CENo'] }}
        </td>
    </tr>
    <tr>
        <td class="border">
            Date 日期：
        </td>
        <td class="border">
            {{ $LicensedPerson['Date'] }}
        </td>
    </tr>
</table>
<div class="border normal-font">
    <p>Account Opening Approved By 開戶批核</p>
</div>
<div class="border normal-font">
    <p>China Yinsheng International Securities Limited 中國銀盛國際證券有限公司</p>
</div>
<table class="normal-font">
    <tr>
        <td rowspan="3" class="border"
            style="width: 50%;vertical-align: text-top;text-align: center;background-color: #AED6F1;">
            <div>Authorized director(s)/Responsible Officer(s)'s Signature</div>
            <div>獲授權董事/負責人員簽署</div>
            <img style="width: 200px" src="{{ $ResponsibleOfficer['Signature'] }}" />
        </td>
        <td class="border" style="width: 25%">
            Name 姓名：
        </td>
        <td class="border" style="width: 25%">
            {{ $ResponsibleOfficer['Name'] }}
        </td>
    </tr>
    <tr>
        <td class="border">
            Date 日期：
        </td>
        <td class="border">
            {{ $ResponsibleOfficer['Date'] }}
        </td>
    </tr>
    <tr>
        <td class="border">
        </td>
        <td class="border">
        </td>
    </tr>
</table>
{{-- <div class="page-break"></div> --}}
<div class="border normal-font" style="text-align: center;background-color: #AED6F1;">
    <div>For Offical Use Only</div>
    <div>只供本公司使用</div>
</div>
<div class="border normal-font">
    <div>
        Name of Account Executive:
    </div>
    <table>
        <tr>
            <td>
                - Securities: ___________________________
            </td>
            <td>
                AE code: ___________________________
            </td>
        </tr>
    </table>
</div>
<div class="border normal-font">
    <p>
        Document reviewed by
    </p>
</div>
<table class="normal-font">
    <tr>
        <td style="width: 33%" class="border">
            <p>
                Name of Staff:
            </p>
            <p>
                {{ $DocumentReviewedBy['Name'] }}
            </p>
        </td>
        <td style="width: 33%" class="border" colspan="2">
            <p>
                Signature of Staff:
            </p>
            <p>
                {{ $DocumentReviewedBy['Signature'] }}
            </p>
        </td>
        <td style="width: 33%" class="border" colspan="2">
            <p>
                Date:
            </p>
            <p>
                {{ $DocumentReviewedBy['Date'] }}
            </p>
        </td>
    </tr>
    <tr>
        <td style="width: 33%" class="border">
            <p>
                Account Type
            </p>
        </td>
        <td style="width: 33%" class="border" colspan="2">
            <p>
                Commission – by Telephone
            </p>
        </td>
        <td style="width: 33%" class="border" colspan="2">
            <p>
                Commission – by Internet Trading
            </p>
        </td>
    </tr>
    <tr>
        <td class="border" style="width: 33%">
            <p>
                - Securities Cash
            </p>
        </td>
        <td class="border" style="width: 16.5%">
            <p>
                Brokerage (%)
            </p>
        </td>
        <td class="border" style="width: 16.5%">
            <p>
                Min.
            </p>
        </td>
        <td class="border" style="width: 16.5%">
            <p>
                Brokerage (%)
            </p>
        </td>
        <td class="border" style="width: 16.5%">
            <p>
                Min.
            </p>
        </td>
    </tr>
    <tr>
        <td class="border" style="width: 33%">
            <p>
                - Securities Margin
            </p>
        </td>
        <td class="border" style="width: 16.5%">
            <p>
                Brokerage (%)
            </p>
        </td>
        <td class="border" style="width: 16.5%">
            <p>
                Min.
            </p>
        </td>
        <td class="border" style="width: 16.5%">
            <p>
                Brokerage (%)
            </p>
        </td>
        <td class="border" style="width: 16.5%">
            <p>
                Min.
            </p>
        </td>
    </tr>
</table>
<div class="border normal-font">
    <p>
        Credit/ Margin Limit
    </p>
</div>
<table class="normal-font">
    <tr>
        <td class="border" style="width: 33%">
            <p>
                Securities Cash
            </p>
        </td>
        <td class="border" style="width: 33%">
            <p>
                Securities Margin
            </p>
        </td>
        <td class="border" style="width: 33%">
        </td>
    </tr>
</table>
<div class="border normal-font">
    <p>
        Limit Approved by
    </p>
</div>
<table class="normal-font">
    <tr>
        <td class="border" style="width: 33%">
            <p>
                Name of Staff:
            </p>
        </td>
        <td class="border" style="width: 33%">
            <p>
                Signature of Staff:
            </p>
        </td>
        <td class="border" style="width: 33%">
            <p>
                Date
            </p>
        </td>
    </tr>
</table>
<div class="border normal-font">
    <p>
        Remarks
    </p>
</div>
<div class="page-break"></div>
<div class="border normal-font" style="text-align: center;background-color:#AED6F1;">
    <div>Documentation Check List For Account Opening</div>
    <div>開立帳戶之文件核對表</div>
</div>
<div class="border normal-font">
    <div>重要事項：所有提交的文件如非正本，必須經認可人士或中國銀盛員工認證後，方為有效。</div>
    <div>Important note: All documents submitted must either be
        an original or a copy certified by a recognized person
        or staff members of CYSS.</div>
    <p></p>
    <div>
        個人/聯名戶口 INDIVIDUAL/JOINT ACCOUNT
    </div>
    <div>
        請提供以下文件本Please provide the following documents:
    </div>
    <p></p>
    <div>
        1. 個人/聯名戶口持有人身份證/護照副本
    </div>
    <div>
        Identity Card(s)/Passport(s) of the Individual/Joint account holder
    </div>
    <p></p>
    <div>
        2. 住宅地址證明 ( 如：水、電費單/銀行結單等, 只接受最近三個月 ) 或
    </div>
    <div>
        Proof of Residential Address (e.g. Utilities/Bank Statement, etc. not later than 3 months) or
    </div>
    <p></p>
    <div>
        3. 通訊地址證明 (如適用)
    </div>
    <div>
        Proof of Correspondence Address (If applicable)
    </div>
    <p></p>
    <div>
        4. 中國銀盛合理情況下需要的其他文件或資料
    </div>
    <div>
        Any other documents and/or information as CYSS may reasonably requires
    </div>
</div>
