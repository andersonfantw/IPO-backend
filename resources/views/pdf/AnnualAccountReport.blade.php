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
        .text-left{
            text-align: left;
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
        <div>???????????????????????? 9 ??? 6 ???</div>
        <div><small>6/F., 9 Des Voeux Road West, Sheung Wan, Hong Kong</small></div>
        <div><span>Tel ??????: (852) 2626 0778</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Fax ??????: (852) 2111 1052 Website</span>&nbsp;&nbsp;&nbsp;<span>??????: www.chinayss.hk</span></div>
    </footer>

    <div class="container">
        <h1>????????????????????????</h1>
        <table class="info" width="100%" cellspacing="0">
            <tbody>
                <tr><td>????????????(Account No) : <u>{{$data['User']['client_acc_id']}}</u></td></tr>
                <tr><td>????????????(Account Name) : <u>{{$data['User']['name']}}</u></td></tr>
                <tr><td>????????????: {{$data['AccountReportSendingSummary']['start_date']->format('d-M-y')}} ??? {{$data['AccountReportSendingSummary']['end_date']->format('d-M-y')}} ??? <div class="float-right">??????????????????: {{$data['AccountReportSendingSummary']['report_make_date']->format('d-M-y')}}</div></td></tr>
            </tbody>
        </table>
        <br />
        <br />
        <h4>??????????????????</h4>
        <table id="account_summary" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="text-center">??????</th>
                    <th>??????</th>
                    <th>??????</th>
                    <th class="text-center">??????(??????)</th>
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
                    <td>??????????????????</td>
                    <td></td>
                    <td>{{number_format($data['TempIpoSummary']['prev_account_value'],2)}}</td>
                </tr>
                @else
                <tr class="dashed">
                    <td></td>
                    <td>??????????????????</td>
                    <td></td>
                    <td>0.00</td>
                </tr>
                @endif

                @for ($i=0;$i<count($data['Deposits']);$i++)
                    @if ($i==count($data['Deposits'])-1)
                <tr class="dashed">
                    @else
                <tr>
                    @endif
                        
                    <td>{{$data['Deposits'][$i]['buss_date']}}</td>
                        @if (!isset($data['TempIpoSummary']['init_value_date']))
                    <td>{{$data['Deposits'][$i]['method']}}</td>
                        @elseif ($data['TempIpoSummary']['init_value_date']->eq($data['Deposits'][$i]['buss_date']))
                    <td>????????????</td>
                        @else
                    <td>{{$data['Deposits'][$i]['method']}}</td>
                        @endif
                    <td>{{number_format($data['Deposits'][$i]['amount'],2)}}</td>
                    <td>{{number_format($data['Deposits'][$i]['avail_bal'],2)}}</td>
                        
                </tr>
                @endfor

                <tr>
                    <td>{{$data['AccountReportSendingSummary']['report_make_date']->subDay()->format('d-M-y')}}</td>
                    <td>??????????????????</td>
                    <td></td>
                    <td>{{number_format($data['TempIpoSummary']['avail_bal']-$data['TempIpoSummary']['current_subscription']-$data['TempIpoSummary']['current_loan']-$data['TempIpoSummary']['current_fee']+$data['PortfolioMarketValue'],2)}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>??????:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>?????????</td>
                    <td>{{number_format($data['TempIpoSummary']['avail_bal'],2)}}</td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>IPO ?????????????????? </td>
                    <td>{{number_format(-$data['TempIpoSummary']['current_subscription'],2)}}</td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>????????????</td>
                    <td>{{number_format(-$data['TempIpoSummary']['current_loan'],2)}}</td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>???????????????</td>
                    <td>{{number_format(-$data['TempIpoSummary']['current_fee'],2)}}</td>
                    <td></td>
                </tr>
                <tr class="subitem solid">
                    <td></td>
                    <td>??????????????????</td>
                    <td>{{number_format($data['PortfolioMarketValue'],2)}}</td>
                    <td></td>
                </tr>

                <tr>
                    <td>{{$data['AccountReportSendingSummary']['report_make_date']->subDay()->format('d-M-y')}}</td>
                    <td>????????????</td>
                    <td></td>
                    <td>{{number_format($data['TempIpoSummary']['avail_bal']-$data['TempIpoSummary']['current_subscription']-$data['TempIpoSummary']['current_loan']-$data['TempIpoSummary']['current_fee']+$data['PortfolioMarketValue'] - $data['InitValue'],2)}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>??????:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>????????????????????????</td>
                    <td>0.00</td>
                    <td></td>
                </tr>
                <tr class="subitem">
                    <td></td>
                    <td>???????????????</td>
                    <td>{{number_format($data['TempIpoSummary']['avail_bal']-$data['TempIpoSummary']['current_subscription']-$data['TempIpoSummary']['current_loan']-$data['TempIpoSummary']['current_fee']+$data['PortfolioMarketValue'] - $data['InitValue'],2)}}</td>
                    <td></td>
                </tr>

            </tbody>
        </table>
        <br />
        <div>
            <b>??????:</b>
            <ol>
                @if ($data['TempIpoSummary']['this_performance_fee'] > 0)
                <li>?????????: {{number_format($data['TempIpoSummary']['this_performance_fee'],2)}} ({{number_format($data['TempIpoSummary']['restore_avail_bal'] - $data['TempIpoSummary']['correct_init_val'],2)}}*{{$data['TempIpoSummary']['percent']*100}}%)?????? {{$data['AccountReportSendingSummary']['performance_fee_date']->format('Y/m/d')}} ??????</li>
                @endif
                <li>????????????????????????????????????????????????????????????????????????</li>
                @if ($data['TempIpoSummary']['current_fee']<0)
                <li>?????????????????????????????????2190???????????????????????????????????????????????????????????????????????????</li>
                @endif
            </ol>
        </div>
        <br />
        <br />
        <h4>???. ????????????</h4>
        <table id="stock" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>????????????</th>
                    <th>??????</th>
                    <th>??????</th>
                    <th>??????</th>
                </tr>
            </thead>
            <tbody>
                @if(empty($data['Alloted']))
                <tr>
                    <td colspan="4" class="text-center">???</td>
                </tr>
                @endif
                @foreach($data['Alloted'] as $alloted)
                <tr>
                    <td>{{$alloted['product_id']}} {{$alloted['product_name']}}</td>
                    <td>{{number_format($alloted['qty'],0)}}</td>
                    <td>{{number_format($alloted['allot_price1'],2)}}</td>
                    <td>{{number_format($alloted['amount'],2)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br />
        <br />
        <h4>???. ??????????????????</h4>
        <div id="section3">{!! $section3 !!}<br /></div>
    </div>
</body>
</html>
