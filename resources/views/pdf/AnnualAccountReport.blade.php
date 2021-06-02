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
            width: 715px;
            margin: 0 auto;
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
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        header {
            position: fixed;
            top: 0px;
            height: 60px;
        }
        footer{
            width: 715px;
            display: block;
            bottom: 0px;
            height: 50px;
            position: fixed;
            text-align: center;
            background-color: white;
            color: #2e3f79;
        }
        #watermark {
            position: fixed;
            bottom:   5cm;
            width:    18cm;
            height:   16cm;
            z-index:  -1000;
            opacity: 0.1;
        }
        #account_summary tbody td:nth-child(1){
            text-align: center;
        }
        #account_summary tbody td:nth-child(3){
            text-align: right;
        }
        #account_summary tbody td:nth-child(4){
            text-align: right;
            font-weight: bold;
        }
        #account_summary tbody tr.subitem td:nth-child(2){
            text-align: right;
        }
        #section3{
            width: 640px;
            text-align: justify;
            text-justify:inter-ideograph;
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
    <div id="watermark">
        <img src="{{$watermark}}" width="100%" height="100%" />
    </div>
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
        <br />
        <h4>一、帳戶資訊</h4>
        <table id="account_summary" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="text-center">日期</th>
                    <th>項目</th>
                    <th>說明</th>
                    <th class="text-center">金額(港幣)</th>
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
                <tr class="subitem">
                    <td></td>
                    <td>總結餘</td>
                    <td>6,090,063.15</td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>IPO 申請凍結資金 </td>
                    <td>4,343.34</td>
                    <td></td>
                </tr>
                <tr class="subitem solid">
                    <td></td>
                    <td>投資組合市值</td>
                    <td>0.00</td>
                    <td></td>
                </tr>

                <tr>
                    <td>31-Aug-20</td>
                    <td>帳戶變動</td>
                    <td></td>
                    <td>835,693.47</td>
                </tr>
                <tr>
                    <td></td>
                    <td>其中:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>投資組合市值異動</td>
                    <td>0.00</td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>已實現損益</td>
                    <td>835,693.47</td>
                    <td></td>
                </tr>
                <tr class="subitem">
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
                    <td colspan="4" class="text-center">無</td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <h4>三. 投資人報告書</h4>
        <div id="section3">{!! $section3 !!}<br /></div>
    </div>
</body>
</html>
