<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        #account_summary tbody td:nth-child(1),
        #stock tbody td:nth-child(1),
        #stock tbody td:nth-child(2){
            text-align: center;
        }
        #account_summary tbody td:nth-child(3),
        #stock thead th:nth-child(3),
        #stock thead th:nth-child(4),
        #stock tbody td:nth-child(3){
            text-align: right;
        }
        #account_summary tbody td:nth-child(4),
        #stock tbody td:nth-child(4){
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
                <tr><td>帳戶編號(Account No) : <u>{{$data['User']['client_acc_id']}}</u></td></tr>
                <tr><td>帳戶名稱(Account Name) : <u>{{$data['User']['name']}}</u></td></tr>
                <tr><td>報告期間: {{$data['AccountReportSendingSummary']['start_date']->format('d-M-y')}} 至 {{$data['AccountReportSendingSummary']['end_date']->format('d-M-y')}} 止 <div class="float-right">報告編制日期: {{$data['AccountReportSendingSummary']['report_make_date']->format('d-M-y')}}</div></td></tr>
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
                @if ($data['TempIpoSummary']['prev_client']=='Y')
                    @if (empty($data['Deposits']))
                <tr>
                    @else
                <tr class="dashed">
                    @endif

                    @if ($data['TempIpoSummary']['init_value_date'])
                    <td>{{$data['TempIpoSummary']['init_value_date']->format('d-M-y')}}</td>
                    @else
                    <td>{{$data['TempIpoSummary']['ipo_activity_periods_start_date']->format('d-M-y')}}</td>
                    @endif
                    <td>上期帳戶總值</td>
                    <td></td>
                    <td>{{number_format($data['TempIpoSummary']['init_value'],2)}}</td>
                </tr>
                @endif

                @for ($i=0;$i<count($data['Deposits']);$i++)
                    @if ($i==count($data['Deposits'])-1)
                <tr class="dashed">
                    @else
                <tr>
                    @endif
                        
                    <td>{{$data['Deposits'][$i]['buss_date']}}</td>
                        @if ($data['TempIpoSummary']['init_value_date']->eq($data['Deposits'][$i]['buss_date']))
                    <td>初始入金</td>
                        @else
                    <td>{{$data['Deposits'][$i]['method']}}</td>
                        @endif
                    <td>{{number_format($data['Deposits'][$i]['amount'],2)}}</td>
                    <td>{{number_format($data['Deposits'][$i]['avail_bal'],2)}}</td>
                        
                </tr>
                @endfor

                <tr>
                    <td>{{$data['AccountReportSendingSummary']['report_make_date']->subDay()->format('d-M-y')}}</td>
                    <td>本期帳戶總值</td>
                    <td></td>
                    <td>{{number_format ($data['TempIpoSummary']['avail_bal']+$data['TempIpoSummary']['current_subscription']+$data['TempIpoSummary']['current_loan']+$data['PortfolioMarketValue'],2)}}</td>
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
                    <td>{{number_format($data['TempIpoSummary']['avail_bal'],2)}}</td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>IPO 申請凍結資金 </td>
                    <td>{{number_format($data['TempIpoSummary']['current_subscription'],2)}}</td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>融資資金</td>
                    <td>{{number_format($data['TempIpoSummary']['current_loan'],2)}}</td>
                    <td></td>
                </tr>
                <tr class="subitem solid">
                    <td></td>
                    <td>投資組合市值</td>
                    <td>{{number_format($data['PortfolioMarketValue'],2)}}</td>
                    <td></td>
                </tr>

                <tr>
                    <td>{{$data['AccountReportSendingSummary']['report_make_date']->subDay()->format('d-M-y')}}</td>
                    <td>帳戶變動</td>
                    <td></td>
                    <td>{{number_format($data['TempIpoSummary']['avail_bal'] - $data['InitValue'],2)}}</td>
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
                    @if ($data['TempIpoSummary']['current_program']=='C' || strlen($data['TempIpoSummary']['client_acc_id'])===8)
                    <td>0.00</td>
                    @endif
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>已實現損益</td>
                    <td>{{number_format($data['TempIpoSummary']['avail_bal'] - $data['TempIpoSummary']['init_value'],2)}}</td>
                    <td></td>
                </tr>

            </tbody>
        </table>
        <br />
        <div>
            <b>說明:</b>
            <ol>
                @if ($data['TempIpoSummary']['avail_bal'] - $data['InitValue'] > 0)
                    @if ($data['TempIpoSummary']['current_program']=='C' || strlen($data['TempIpoSummary']['client_acc_id'])===8)
                <li>表現費: {{number_format(($data['TempIpoSummary']['avail_bal'] - $data['InitValue'])*0.2,2)}} ({{number_format($data['TempIpoSummary']['avail_bal'] - $data['InitValue'],2)}}*20%)將於 {{$data['AccountReportSendingSummary']['performance_fee_date']->format('Y/m/d')}} 扣除</li>
                    @else
                <li>表現費: {{number_format(($data['TempIpoSummary']['avail_bal'] - $data['InitValue'])*0.8,2)}} ({{number_format($data['TempIpoSummary']['avail_bal'] - $data['InitValue'],2)}}*80%)將於 {{$data['AccountReportSendingSummary']['performance_fee_date']->format('Y/m/d')}} 扣除</li>
                    @endif
                @else
                <li>本期管理費豁免。</li>
                @endif
                <li>與交易相關的手續費，請參閱報告期間的日交易報表。</li>
            </ol>
        </div>
        <br />
        <br />
        <h4>二. 庫存資訊</h4>
        <table id="stock" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>標的名稱</th>
                    <th>數量</th>
                    <th>市價</th>
                    <th>市值</th>
                </tr>
            </thead>
            <tbody>
                @if(empty($data['Alloted']))
                <tr>
                    <td colspan="4" class="text-center">無</td>
                </tr>
                @endif
                @foreach($data['Alloted'] as $alloted)
                <tr>
                    <td>{{$alloted['product_name']}}</td>
                    <td>{{number_format($alloted['qty'],0)}}</td>
                    <td>{{number_format($alloted['allot_price1'],2)}}</td>
                    <td>{{number_format($alloted['amount'],2)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br />
        <br />
        <h4>三. 投資人報告書</h4>
        <div id="section3">{!! $section3 !!}<br /></div>
    </div>
</body>
</html>
