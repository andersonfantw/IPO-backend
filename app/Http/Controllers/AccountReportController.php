<?php

namespace App\Http\Controllers;

use App\AccountReportSendingSummary;
use Illuminate\Http\Request;
use App\Http\Requests\AccountReportFormRequest;
use App\AccountReport;
use App\CysislbGtsClientAcc;
use App\TempIpoSummary;
use App\A01;
use App\A05;
use App\A06;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\Traits\Report;

class AccountReportController extends Controller
{
    use Report;

    protected $name = 'AccountReport';

    public function findClient(Request $request){
        $input = $request->only('acc_no');

        return CysislbGtsClientAcc::select('client_acc_id','name')->where('client_acc_id','like',$input['acc_no'].'%')->get();
    }

    public function store(Request $request, $id){
        $input = $request->only('client_acc_id','client_name');
        $AccountReport = AccountReport::firstOrNew(
            ['client_acc_id'=>$input['client_acc_id']],
            [
                'account_report_sending_summary_id'=>$id,
                'status' => 'pending'
            ]
        );
        if($AccountReport->exists){
            return ['ok'=>false,'msg'=>sprintf('客戶 %s 編號 %s 已在清單中!',$input['client_name'],$input['client_acc_id'])];
        }else{
            return ['ok'=>true];
        }

    }

    public function index(Request $request, $id){
        $AccountReport = AccountReport::with([
            'ClientInfo' => function($query) use($request){
                $query->select('client_acc_id','name','email');
                $request->whenFilled('name',function($input) use($query){
                    $query->where('name','like','%'.$input.'%');
                });
            }
        ])->ofParentID($id);
        $request->whenFilled('make_report_status', function($input) use ($AccountReport){
            if($input!='all') {
                if ($input == 'null') $AccountReport->whereNull('make_report_status');
                else $AccountReport->where('make_report_status', '=', $input);
            }
        });
        $request->whenFilled('sending_status', function($input) use ($AccountReport){
            if($input!='all') {
                if ($input == 'null') $AccountReport->whereNull('sending_status');
                else $AccountReport->where('sending_status', '=', $input);
            }
        });
        $request->whenFilled('client_acc_id', function($input) use ($AccountReport){
            $AccountReport->where('client_acc_id','like',$input.'%');
        });
        return array_merge(
            $AccountReport->paginate(100)->toArray(),
            [
                'buttons' => [
                    'total' => AccountReport::ofParentID($id)->count(),
                    'pdf'=> array_merge(
                        ['null'=>0,'pending'=>0,'success'=>0,'fail'=>0],
                        AccountReport::ofParentID($id)->select(DB::raw("ifnull(make_report_status,'null') as make_report_status"),DB::raw('count(*) as total'))->groupBy('make_report_status')->pluck('total','make_report_status')->toArray()
                    ),
                    'email'=> array_merge(
                        ['null'=>0,'pending'=>0,'success'=>0,'fail'=>0],
                        AccountReport::ofParentID($id)->select(DB::raw("ifnull(sending_status,'null') as sending_status"),DB::raw('count(*) as total'))->groupBy('sending_status')->pluck('total','sending_status')->toArray()
                    ),
                ]
            ]
        );
    }

    // 選擇項目的功能
    public function makePdf(Request $request, $id){
        $input = $request->only('list');
        foreach(explode(',',$input['list']) as $client_acc_id) {
            Artisan::call('AccountReport:MakePdf', [
                'id' => $id,
                '--client' => $client_acc_id
            ]);
        }
        return ['ok'=>true];
    }
    public function sendTestMail(){

    }
    public function sendMail(){

    }
    public function removeClient(Request $request,$id){
        $input = $request->only('list');
        foreach(explode(',',$input['list']) as $client_acc_id){
            AccountReport::where('account_report_sending_summary_id','=',$id)->where('client_acc_id','=',$client_acc_id)->delete();
        }
        return ['ok'=>true];
    }

    // 全部清單的功能
    public function makeAll($id){
        Artisan::call('AccountReport:MakePdf', [
            'id'=>$id,
        ]);
        return ['ok'=>true];
    }
    public function sendAll(){

    }

    private function prepareDocData(AccountReportSendingSummary $AccountReportSendingSummary, $client_acc_id){
        $CysislbGtsClientAcc = CysislbGtsClientAcc::where('client_acc_id','=',$client_acc_id)->first();
        $TempIpoSummary = TempIpoSummary::where('client_acc_id','=',$client_acc_id)->first();
        $AccountReport = AccountReport::where('account_report_sending_summary_id','=',$AccountReportSendingSummary->id)->where('client_acc_id','=',$client_acc_id)->first();
        // 已申購但未抽籤的新股
        $date = Carbon::parse($AccountReportSendingSummary['end_date'])->gt(Carbon::today())?Carbon::today():$AccountReportSendingSummary['end_date'];
        $Subscription = A06::where('client_acc_id','=',$client_acc_id)->whereDate('close_time','>=',$date)->whereDate('allot_date','<',$date)->sum('amount');
        // 已中簽的新股
        $a06_alloted = A06::where('client_acc_id','=',$client_acc_id)
        ->whereDate('allot_date','>=',Carbon::today())
        ->whereNotIn('product_id',A05::where('client_acc_id','=',$client_acc_id)->whereDate('buss_date','<',$AccountReportSendingSummary['end_date'])->get('product_id'))
        ->get('product_id','product_name','allot_price1','qty','amount');

        $Deposits = A01::select('buss_date','amount',DB::raw("case remark when 'OUT_TRANSFER' then '提款' else '入金' end as method"))->where('client_acc_id','=',$client_acc_id)->where('gl_mapping_item_id','=','OTH:Acct1')->where(function ($query){
            $query->whereNull('remark')->orWhere(function ($query){
                $query->where('remark','=','OUT_TRANSFER')->where('ccy','=','HKD');
            });
        })->get();

//         $section3 =<<<TEXT
// 2019 年下半年以來，港股市場面臨的不確定因素增加，除了環球貿易摩擦的影響，本土地緣政治風險也明顯上升。香港恆生指數在 6 月至 9 月的期間，表現明顯跑輸中、美、英、日等其他全球主要股市，香港本地銀行、地產和公用事業板塊的不振，顯著為指數帶來了拋壓。同期，香港新股市場氣氛轉趨淡靜，上市的新股數量和融資金額雙雙下降，新股公開發售的認購超額倍數和發售價格相比 2018 年同期也有一定的下調。直到2019 年 10-11 月，恆生指數受到多項正面因素推動，如貿易戰開始緩和、本土政治風險被市場消化並緩和、美聯儲宣佈重啟資產負債表擴張政策等消息，令市場胃納開始改善，港股市場迎來了一波反彈行情。在這期間，「股王」阿里巴巴正式在香港招股上市，衛冕香港作為全球領先集資樞紐的地位，加上季節效應下，帶動第四季的香港新股市場回暖。
// 踏入 2020 年，因中美貿易戰氣氛緩和，市場憧憬全球央行放水撐市，港股 1 月中一度衝上二萬九點關口，及後俄羅斯與沙特爆發油價戰， 加上 1-2 月新冠肺炎在武漢爆發，並迅速蔓延到全球各地，恆指一度低見 21,139點，恆指首季累跌 4,586 點或 16.3%，錄得為 2015 年第三季以來最大季度百分比跌幅。上市新股的數量急劇從 1 月份的 22 只下滑到 2 月份的 2 只，連累 2020 年 1-6 月的新股上市數量相對去年同期下跌，從去年同期的76 只下降到 59 只，其中主板上市的股票有 54 只，創業板上市的股票則有 5 只。新股融資金額相對去年同期錄得上升，並創下 2015 年以來同期新高，主要是歸功於兩只在美國上市的大型中概科網股在香港作第二上市。2020 上半年接近六成數量的新股來自內地，集資額佔總額的 96%，與去年同期相比，數量佔比略有下降，而集資額佔比上升。其中房地產、科技、傳媒與電信行業新股數量比重最高，比例均較去年同期增加，而消費行業的比重則有所回落。3-6 月期間，影響恆生指數走勢的因素好壞參半，雖然美國聯儲局 3 月下旬宣布推行無限量化寬鬆措施，令全球股市短暫喘穩，配合 2 月沒能上市的公司急於在 3 月上市，3 月新股上市數目大幅反彈至 15 只。不過隨後 5 月份中美關係惡化，衝突升級，大盤再度處於僵持不下的局面。同期新股市場上市數目再度減少，4 月、5 月和 6 月分別只有 8、8、9 只新股上市。2020 年 7 月份，新股市場進入傳統的景氣月，新股密集招股，市場氣氛達至階段性高潮。該月上市的新股數量達 24 只，首日掛牌錄得漲幅的有 16 只，上升比例高達 66.7%。總體來說，2020 年 1-8 月，共有 83 只新股在香港上市，其中有 48 只在首日上市錄得升幅（上升比例 57.8%），有 3 只在首日無漲跌幅（佔比 3.6%）以及 32 只在首日錄得下跌（下跌比例 38.6%）。2019 年 8 月底至 2020 年 8 月底，共有 154 只新股在香港上市，其中有 89 只在首日上市錄得升幅（上升比例57.8%），有 7 只在首日無漲跌幅（佔比 4.5%）以及 58 只在首日錄得下跌（下跌比例 37.7%）。
// 回顧 2019 年 8 月底至 2020 年 8 月底新股委託管理賬戶的表現:參與 69 檔新股交易，扣除手續費後獲利共有47 檔新股獲利，交易勝率 68.1%；管理的專戶 87%戶數取得盈利。
// 展望 2020 年 9-12 月，新股市場會繼續保持穩定發展。預計今年總共會有 130 只新股掛牌，即年內將還有約35-45 只新股將會來港上市，其中 3-6 只為第二上市的中概股。今年下半年全球市場氣氛將繼續受經濟不確定性影響，或會短期內影響 IPO 集資。然而，作為全球數一數二的 IPO 市場，預計香港 IPO 市場將保持穩定，而 TMT、中概科網股回歸及醫療保健/生命科學板塊有望繼續帶動市場，預計 2020 年全年總集資額將達 2,000至 2,500 億港元
// TEXT;
        $section3 = $AccountReportSendingSummary->report;
        return [
            'logo' => $this->imagePathToBase64(public_path('images/logo.png')),
            'watermark' => $this->imagePathToBase64(public_path('images/ccyss-removebg-preview.png')),
            'section3' => $this->fixChineseWrapInPDF($section3),
            'data' => [
                'AccountReportSendingSummary' => $AccountReportSendingSummary,
                'User' => $CysislbGtsClientAcc,
                'TempIpoSummary' => $TempIpoSummary,
                'Deposits' => $Deposits,
                'Subscription' => $Subscription,
                'Alloted_amount' => $a06_alloted->sum('amount'),
                'Alloted' => $a06_alloted->toArray(),
            ]
        ];
    }

    public function showHtml(AccountReportSendingSummary $AccountReportSendingSummary, $client_acc_id){
        return View('pdf.AnnualAccountReport',$this->prepareDocData($AccountReportSendingSummary,$client_acc_id));
    }
    public function showPdf(AccountReportSendingSummary $AccountReportSendingSummary, $client_acc_id){
        $pdf = PDF::loadView('pdf.AnnualAccountReport',$this->prepareDocData($AccountReportSendingSummary,$client_acc_id));
        $pdf->setOptions(['isPhpEnabled' => true]);
        return $pdf->stream('AnnualAccountReport.pdf');
    }
}
