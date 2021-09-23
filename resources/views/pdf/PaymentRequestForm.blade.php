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
            font-size: 11px;
            width: 715px;
            margin: 0 auto;
            background-color: #fff;
        }
        h1, h2{
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 14px;
        }
        h4{
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
        .py-2{
            padding: 0.5rem 0 !important;
        }
        .p-3{
            padding: 1rem !important;
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
        .px-2{
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        .px-3{
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        .px-4{
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
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
        .w-25{
            width: 25%;
        }
        .w-100{
            width: 100%;
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

    <h1>Payment Request Form</h1>
    <div class="container">
        <div class="row">
            <div class="col px-5">
                <table>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><b>Date：{{$month}}</b></td>
                        </tr>
                        <tr>
                            <td style="width:500px;"><u style="font-size:1.3em">Approvel</u></td>
                            <td><b >YSF -</b></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table class="border w-100">
                    <tbody>
                        <tr>
                            <th class="text-left px-4">Payee</th>
                            <td class="text-right px-4">{{$name}}</td>
                        </tr>
                        <tr>
                            <th class="text-left px-4">Payment Period</th>
                            <td class="text-right px-4">{{$month}} ~ {{$end_date}}</td>
                        </tr>
                        <tr>
                            <th class="text-left px-4">AE Commission</th>
                            <td class="text-right px-4">HK${{number_format($subtitle,2)}}</td>
                        </tr>
                        <tr>
                            <th class="text-left px-4">Hold(10%)</th>
                            <td class="text-right px-4">HK${{number_format($subtitle*0.1,2)}}</td>
                        </tr>
                        <tr>
                            <th class="text-left px-4">Total</th>
                            <td class="text-right px-4">HK${{number_format($subtitle*0.9,2)}}</td>
                        </tr>
                        <tr>
                            <th class="text-left px-4"><br /></th>
                            <td class="text-right px-4"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="border w-100" style="border-top:0">
                    <tbody>
                        <tr>
                            <td class="px-4">No (or insufficient) Invoice or Receipt</td>
                            <td style="font-size:1.5em">☐</td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table class="border w-100" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td class="px-4 w-25" style="border-right:solid 1px #000">Payment Request  :</td>
                            <td class="px-4 w-25">Approval By :</td>
                            <td class="w-25"></td>
                            <td class="w-25"></td>
                        </tr>
                        <tr>
                            <td class="text-center" style="border-top:solid 1px #333;border-right:solid 1px #333">Applicant</td>
                            <td class="text-center" style="border-top:solid 1px #333;border-right:solid 1px #333">Manager / V.P.</td>
                            <td class="text-center" style="border-top:solid 1px #333;border-right:solid 1px #333">CFO / COO / CMO</td>
                            <td class="text-center" style="border-top:solid 1px #333">CEO / Director</td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333"><br /><br /><br /></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333"> </td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333"> </td>
                            <td style="border-top:solid 1px #333"> </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <hr style="border:none;border-top:2px dashed #000;" />
                <br />
                <table class="border w-100" style="font-size: 9px" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td class="px-4" colspan="8">EXPENSES:</td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Consultancy fee</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Rents and rates  </td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Entertainment</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333" class="px-2">Salaries & Bonus</td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Valuation fee</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Management & cleaning Fee</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Travelling Fee</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333" class="px-2">MPF</td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Fire insurance</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Electricity</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Telephone & network expenses</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333" class="px-2">Sundry expenses</td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Operating expenses</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Licence & registration expenses</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Welfare expense </td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333" class="px-2">Advertising</td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Computer system expenses</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Medical expenses</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Professional  fees</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333" class="px-2">Transfer to:</td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Bank charges</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Office Supplies</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333" class="px-2"></td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Interest</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2">Postage, printing & stationery</td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333" class="px-2"></td>
                            <td style="border-top:solid 1px #333" class="px-2"></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table class="w-100" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td class="px-4" colspan="4"><u>Payment</u></td>
                        </tr>
                        <tr>
                            <td class="px-4" colspan="4">Please specify the payment method for the expenses :</td>
                        </tr>
                        <tr>
                            <td class="text-left px-4"><span style="font-size:1.5em">☐</span> Cash</td>
                            <td class="text-left px-4"><span style="font-size:1.5em">☐</span> Cheque</td>
                            <td class="text-left px-4"><span style="font-size:1.5em">☐</span> Chats</td>
                            <td class="text-left px-4"><span style="font-size:1.5em">☐</span> TT</td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <br />
                <br />
                <table class="w-100" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td class="px-3" style="width:40%">Bank / Bank A/C No. __________________</td>
                            <td class="px-3" style="width:30%">CQ No.____________________</td>
                            <td class="px-3" style="width:30%">Received By ________________</td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <br />
                <table class="border w-100" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td class="px-4" colspan="4">Check By  : Accounts & Finance Dept.</td>
                        </tr>
                        <tr>
                            <td class="text-center" style="border-top:solid 1px #333;border-right:solid 1px #333">Prepared By</td>
                            <td class="text-center" style="border-top:solid 1px #333;border-right:solid 1px #333">Manager / V.P.</td>
                            <td class="text-center" style="border-top:solid 1px #333;border-right:solid 1px #333">FC / CFO</td>
                            <td class="text-center" style="border-top:solid 1px #333">CEO / Director</td>
                        </tr>
                        <tr>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333"><br /><br /><br /></td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333"> </td>
                            <td style="border-top:solid 1px #333;border-right:solid 1px #333"> </td>
                            <td style="border-top:solid 1px #333"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>