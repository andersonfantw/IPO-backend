<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="x-ua-compatible" content="IE=9;IE=8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>accountOpeningForm DOWNLOAD</title>
    <style>
        body{
            padding: 120px 0 70px 0;
            font-size: 12px;
        }
        h1{
            text-align: center;
            margin-top: 0;
        }
        h4{
            margin: 0;
        }
        table{
            border-bottom: solid 2px #000;
        }
        thead th{
            border-bottom: solid 2px #000;
        }
        .dashed td{
            border-bottom: dashed 1px #000;
        }
        .solid td{
            border-bottom: solid 1px #000;
        }
        .row{
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .col{
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }
        .col-12{
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
        .container{
            margin: 0 40px;
        }
        .info{
            border : solid 3px #000;
        }
        .info td{
            font-size:14px;
            line-height: 16px;
            padding: 0 10px;
        }
        .float-right{
            float: right;
        }
        header {
            position: fixed;
            top: 0px;
            height: 60px;
        }
        footer{
            width: 100%;
            display: block;
            bottom: 0px;
            height: 50px;
            position: fixed;
            text-align: center;
            background-color: white;
            color: #2e3f79;
        }
    </style>
</head>
<body>
    <script type="text/php">
        // OLD
        // $font = Font_Metrics::get_font("helvetica", "bold");
        // $pdf->page_text(72, 18, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(255,0,0));
        // v.0.7.0 and greater
        $x = 510;
        $y = 805;
        $text = "page {PAGE_NUM} of {PAGE_COUNT}";
        $font = $fontMetrics->get_font("helvetica", "bold");
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    </script>
    <header><img src="{{$logo}}" width="500px" /></header>
    <footer>
        <div>香港上環德輔道西 9 號 6 樓</div>
        <div><small>6/F., 9 Des Voeux Road West, Sheung Wan, Hong Kong</small></div>
        <div><span>Tel 電話: (852) 2626 0778</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Fax 傳真: (852) 2111 1052 Website</span>&nbsp;&nbsp;&nbsp;<span>網址: www.chinayss.hk</span></div>
    </footer>

    <div class="container">
        <h1>專戶投資人報告書</h1>
        <table class="info" width="100%" cellspacing="0">
            <tbody>
                <tr><td>帳戶編號(Account No) : <u>3888838</u></td></tr>
                <tr><td>帳戶名稱(Account Name) : <u>LIN ZHONGSHENG JACKY -DS</u></td></tr>
                <tr><td>報告期間: 2019/6/30 至 2020/8/31 止 <div class="float-right">報告編制日期: 2020/9/1</div></td></tr>
            </tbody>
        </table>
        <br />
        <h4>一、帳戶資訊</h4>
        <table width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>項目</th>
                    <th>說明</th>
                    <th>金額(港幣)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>30-Jun-19</td>
                    <td>上期帳戶總值</td>
                    <td></td>
                    <td>1,658,713.02</td>
                </tr>
                <tr>
                    <td>15-Oct-19</td>
                    <td>提款</td>
                    <td>(1,400,000,00)</td>
                    <td>258,713.02</td>
                </tr>
                <tr>
                    <td>24-Feb-20</td>
                    <td>入金</td>
                    <td>2,000,000,00</td>
                    <td>2,258,713.02</td>
                </tr>
                <tr>
                    <td>3-Aug-20</td>
                    <td>入金</td>
                    <td>2,000,000,00</td>
                    <td>4,258,713.02</td>
                </tr>
                <tr class="dashed">
                    <td>14-Aug-20</td>
                    <td>入金</td>
                    <td>1,000,000,00</td>
                    <td>5,258,713.02</td>
                </tr>

                <tr>
                    <td>31-Aug-20</td>
                    <td>本期帳戶總值</td>
                    <td></td>
                    <td>6,094,406.49</td>
                </tr>
                <tr>
                    <td></td>
                    <td>其中:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>總結餘</td>
                    <td>6,090,063.15</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>IPO 申請凍結資金 </td>
                    <td>4,343.34</td>
                    <td></td>
                </tr>
                <tr class="solid">
                    <td></td>
                    <td>投資組合市值</td>
                    <td>0.00</td>
                    <td></td>
                </tr>

                <tr>
                    <td>31-Aug-20</td>
                    <td>帳戶變動</td>
                    <td></td>
                    <td>6,094,406.49</td>
                </tr>
                <tr>
                    <td></td>
                    <td>其中:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>投資組合市值異動</td>
                    <td>0.00</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>已實現損益</td>
                    <td>835,693.47</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>表現費</td>
                    <td>0.00</td>
                    <td></td>
                </tr>

            </tbody>
        </table>
        <br />
        <div>
            <b>說明:</b>
            <ol>
                <li>表現費: 167,138.69 (835,693.47*20%)將於 2020/9/1 扣除</li>
            </ol>
        </div>
        <br />
        <h4>二. 庫存資訊</h4>
        <table width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>標的名稱</th>
                    <th>數量</th>
                    <th>市價</th>
                    <th>市值</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <br />
        <h4>三. 投資人報告書</h4>
        <div>
            2019 年下半年以來，港股市場面臨的不確定因素增加，除了環球貿易摩擦的影響，本土地緣政治風險也明顯
            上升。香港恆生指數在 6 月至 9 月的期間，表現明顯跑輸中、美、英、日等其他全球主要股市，香港本地銀
            行、地產和公用事業板塊的不振，顯著為指數帶來了拋壓。同期，香港新股市場氣氛轉趨淡靜，上市的新股
            數量和融資金額雙雙下降，新股公開發售的認購超額倍數和發售價格相比 2018 年同期也有一定的下調。直到
            2019 年 10-11 月，恆生指數受到多項正面因素推動，如貿易戰開始緩和、本土政治風險被市場消化並緩和、
            美聯儲宣佈重啟資產負債表擴張政策等消息，令市場胃納開始改善，港股市場迎來了一波反彈行情。在這期
            間，「股王」阿里巴巴正式在香港招股上市，衛冕香港作為全球領先集資樞紐的地位，加上季節效應下，帶
            動第四季的香港新股市場回暖。 <br />
            踏入 2020 年，因中美貿易戰氣氛緩和，市場憧憬全球央行放水撐市，港股 1 月中一度衝上二萬九點關口，及
            後俄羅斯與沙特爆發油價戰， 加上 1-2 月新冠肺炎在武漢爆發，並迅速蔓延到全球各地，恆指一度低見 21,139
            點，恆指首季累跌 4,586 點或 16.3%，錄得為 2015 年第三季以來最大季度百分比跌幅。上市新股的數量急劇
            從 1 月份的 22 只下滑到 2 月份的 2 只，連累 2020 年 1-6 月的新股上市數量相對去年同期下跌，從去年同期的
            76 只下降到 59 只，其中主板上市的股票有 54 只，創業板上市的股票則有 5 只。新股融資金額相對去年同期
            錄得上升，並創下 2015 年以來同期新高，主要是歸功於兩只在美國上市的大型中概科網股在香港作第二上市。
            2020 上半年接近六成數量的新股來自內地，集資額佔總額的 96%，與去年同期相比，數量佔比略有下降，而
            集資額佔比上升。其中房地產、科技、傳媒與電信行業新股數量比重最高，比例均較去年同期增加，而消費
            行業的比重則有所回落。3-6 月期間，影響恆生指數走勢的因素好壞參半，雖然美國聯儲局 3 月下旬宣布推行
            無限量化寬鬆措施，令全球股市短暫喘穩，配合 2 月沒能上市的公司急於在 3 月上市，3 月新股上市數目大幅
            反彈至 15 只。不過隨後 5 月份中美關係惡化，衝突升級，大盤再度處於僵持不下的局面。同期新股市場上市
            數目再度減少，4 月、5 月和 6 月分別只有 8、8、9 只新股上市。2020 年 7 月份，新股市場進入傳統的景氣月，
            新股密集招股，市場氣氛達至階段性高潮。該月上市的新股數量達 24 只，首日掛牌錄得漲幅的有 16 只，上
            升比例高達 66.7%。總體來說，2020 年 1-8 月，共有 83 只新股在香港上市，其中有 48 只在首日上市錄得升幅
            （上升比例 57.8%），有 3 只在首日無漲跌幅（佔比 3.6%）以及 32 只在首日錄得下跌（下跌比例 38.6%）。
            2019 年 8 月底至 2020 年 8 月底，共有 154 只新股在香港上市，其中有 89 只在首日上市錄得升幅（上升比例
            57.8%），有 7 只在首日無漲跌幅（佔比 4.5%）以及 58 只在首日錄得下跌（下跌比例 37.7%）。<br />
            回顧 2019 年 8 月底至 2020 年 8 月底新股委託管理賬戶的表現:參與 69 檔新股交易，扣除手續費後獲利共有
            47 檔新股獲利，交易勝率 68.1%；管理的專戶 87%戶數取得盈利。<br />
            展望 2020 年 9-12 月，新股市場會繼續保持穩定發展。預計今年總共會有 130 只新股掛牌，即年內將還有約
            35-45 只新股將會來港上市，其中 3-6 只為第二上市的中概股。今年下半年全球市場氣氛將繼續受經濟不確定
            性影響，或會短期內影響 IPO 集資。然而，作為全球數一數二的 IPO 市場，預計香港 IPO 市場將保持穩定，
            而 TMT、中概科網股回歸及醫療保健/生命科學板塊有望繼續帶動市場，預計 2020 年全年總集資額將達 2,000
            至 2,500 億港元<br />
        </div>
    </div>
</body>
</html>
