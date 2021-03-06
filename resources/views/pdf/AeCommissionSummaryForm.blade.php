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
            padding: 63px 0 50px 0;
            font-size: 14px;
            width: 1016px;
            margin: 0 auto;
            background-color: #fff;
        }
        h1, h2{
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
        }
        h3, h4{
            margin: 0;
        }
        table{
            
        }
        thead th{
            border-bottom: solid 2px #000;
        }
        .border{
            border: solid 2px #000;
        }
        .p-3{
            padding: 1rem !important;
        }
        .py-2{
            padding: 0.5rem 0 !important;
        }
        .px-3{
            padding: 0 1.5rem !important;
        }
        .p-4{
            padding: 1.5rem !important;
        }
        .p-5{
            padding: 3rem !important;
        }
        .py-4{
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }
        .px-5{
            padding-left: 3rem !important;
            padding-right: 3rem !important;
        }
        .mx-4{
            margin-left: 1.5rem !important;
            margin-right: 1.5rem !important;
        }
        .dashed td{
            border-bottom: dashed 1px #000;
        }
        .solid td{
            border-bottom: solid 1px #000;
        }
        .container{
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
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
        .row>* {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
            margin-top: var(--bs-gutter-y);
        }
        .col{
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }
        .col-2{
            -webkit-box-flex: 0;
            -ms-flex: 0 0 16.66%;
            flex: 0 0 16.66%;
            max-width: 16.66%;
        }
        .col-3{
            -webkit-box-flex: 0;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }
        .col-6{
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }
        .col-8{
            -webkit-box-flex: 0;
            -ms-flex: 0 0 66.67%;
            flex: 0 0 66.67%;
            max-width: 66.67%;
        }
        .col-9{
            -webkit-box-flex: 0;
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }
        .col-12{
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
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
        .w-100{
            width: 100%;
        }
        header {
            position: fixed;
            top: 0;
            height: 50px;
        }
        footer{
            width: 1000px;
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
            bottom:   1cm;
            width:    18cm;
            height:   16cm;
            z-index:  -1000;
            opacity: 0.1;
            left: 4cm;
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
        @charset "UTF-8";
    </style>
</head>
<body>
    <script type="text/php">
        // OLD
        // $font = Font_Metrics::get_font("helvetica", "bold");
        // $pdf->page_text(72, 18, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(255,0,0));
        // v.0.7.0 and greater
        $x = 610;
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
    <header>
        <img src="{{$logo}}" width="400px" />
    </header>
    <footer>
        <div>???????????????????????? 9 ??? 6 ???</div>
        <div><small>6/F., 9 Des Voeux Road West, Sheung Wan, Hong Kong</small></div>
        <div><span>Tel ??????: (852) 2626 0778</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>Fax ??????: (852) 2111 1052 Website</span>&nbsp;&nbsp;&nbsp;<span>??????: www.chinayss.hk</span></div>
    </footer>
    
    <table style="width:100%">
        <tr>
            <td style="width:70%">
                <h3>China Yinsheng International Securities Ltd.,</h3>
            </td>
            <td>??????:</td>
            <td>{{$buss_date}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <h3>???????????????????????????\???????????????</h3>
            </td>
            <td>??????:</td>
            <td>{{$start_date}}</td>
            <td>-</td>
            <td>{{$end_date}}</td>
        </tr>
    </table>
    <hr />
    <table style="width:100%">
        <thead>
            <tr>
                <th>????????????</th>
                <th>???????????????</th>
                <th>????????????</th>
                <th>??????????????????</th>
                <th>??????????????????</th>
                <th>????????????</th>
                <th>?????????</th>
                <th>?????????????????????</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ae as $row)
            <tr>
                <td class="text-center">{{$row['name']}}</td>
                <td class="text-center">{{$row['qualified']}}</td>
                <td class="text-right">HK${{number_format($row['excitation'],2)}}</td>
                <td class="text-right">HK${{number_format($row['commission1'],2)}}</td>
                <td class="text-right">HK${{number_format($row['commission2'],2)}}</td>
                <td class="text-right">HK${{number_format($row['subtitle'],2)}}</td>
                <td class="text-right">HK${{number_format($row['reservations'],2)}}</td>
                <td class="text-right">HK${{number_format($row['commission'],2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br />
    @if ($licensed_staff)
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width:9%">????????????</th>
                <th style="width:11%">???????????????</th>
                <th style="width:12%">????????????</th>
                <th>??????</th>
                <th style="width:13%">?????????</th>
                <th style="width:15%">?????????????????????</th>
            </tr>
        </thead>
        <tbody>
            @foreach($licensed_staff as $row)
            <tr>
                <td class="text-center">{{$row['name']}}</td>
                <td class="text-center">{{$row['qualified']}}</td>
                <td class="text-right">HK${{number_format($row['excitation'],2)}}</td>
                <td class="px-3">{{$row['content']}}</td>
                <td class="text-right">HK${{number_format($row['reservations'],2)}}</td>
                <td class="text-right">HK${{number_format($row['commission'],2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <br />

    @if ($no_license_staff)
    <table style="width:100%">
        <thead>
            <tr>
                <th style="width:9%">???????????????</th>
                <th style="width:11%">???????????????</th>
                <th style="width:12%">????????????</th>
                <th>??????</th>
                <th style="width:13%">?????????</th>
                <th style="width:15%">?????????????????????</th>
            </tr>
        </thead>
        <tbody>
            @foreach($no_license_staff as $row)
            <tr>
                <td class="text-center">{{$row['name']}}</td>
                <td class="text-center">{{$row['qualified']}}</td>
                <td class="text-right">HK${{number_format($row['excitation'],2)}}</td>
                <td class="px-3">{{$row['content']}}</td>
                <td class="text-right">HK${{number_format($row['reservations'],2)}}</td>
                <td class="text-right">HK${{number_format($row['commission'],2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if (!$licensed_staff)
    <br /><br /><br /><br />
    @endif
    @if (!$no_license_staff)
    <br /><br /><br /><br />
    @endif

    <br />

    <table style="width:100%">
        <thead>
            <tr>
                <th style="width:9%">??????????????????</th>
                <th style="width:11%">???????????????</th>
                <th style="width:15%">??????????????????</th>
                <th style="width:37%">??????????????????</th>
                <th>??????</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">??????</td>
                <td class="text-center">{{$qualified}}</td>
                <td class="text-center">HK${{number_format($qualified*50,2)}}</td>
                <td class="text-center">HK${{number_format($total_group_open,2)}}</td>
                <td>????????????:50</td>
            </tr>
            <tr>
                <td class="text-center">??????</td>
                <td></td>
                <td class="text-center">HK${{number_format(($performance+$cost)*0.1,2)}}</td>
                <td class="text-center">HK${{number_format($total_group_commission,2)}}</td>
                @if ($commission_content)
                <td>{{$commission_content}}</td>
                @else
                <td>1/2?????????????????????10%</td>
                @endif
            </tr>
        </tbody>
    </table>

    <br />

    <table style="width:100%;">
        <tbody>
            <tr>
                <td style="width:85%">
                    <table style="width:100%; border: solid 3px blue">
                        <tbody>
                            <tr>
                                <td class="text-right"><h3>???????????????_____________________________</h3></td>
                                <td class="text-right"></td>
                                <td class="text-right" style="width:10%;height:1cm"></td>
                            </tr>
                            <tr>
                                <td class="text-right"><h3>???????????????_____________________________</h3></td>
                                <td class="text-right"><h3>??????????????????_____________________________</h3></td>
                                <td class="text-right" style="width:10%;height:1cm"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table style="width:100%;">
                        <tbody>
                            <tr>
                                <td class="text-center">?????????????????????</td>
                            </tr>
                            <tr>
                                <td style="border:solid 2px #000;height:1cm;text-align:center;background-color:rgb(213, 220, 224);"><h3>HK${{number_format($commission,2)}}</h3></td>
                            </tr>                
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>