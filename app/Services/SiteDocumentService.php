<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\ViewClient;
use App\CysislbGtsClientAcc;
use App\TempIpoSummary;
use App\A06;
use App\A05;
use App\A01;
use App\AccountReportSendingSummary;
use App\Traits\Report;

class SiteDocumentService
{
    use Report;

    public static function getStoragePath(string $uuid, Carbon $report_make_date, int $client_acc_id){
        return 'upload/'.$uuid.sprintf('/AnnualAccountReport[%s]_%s.pdf',$report_make_date->format('YM'), $client_acc_id);
    }

    public function AnnualAccountReportData(AccountReportSendingSummary $AccountReportSendingSummary, int $client_acc_id){
        $ViewClient = ViewClient::where('account_no','=',$client_acc_id);
        if(!$ViewClient) return [
            'ok'=>false,
            'msg'=>'ViewClient missing data account_no='.$client_acc_id
        ];
        $CysislbGtsClientAcc = CysislbGtsClientAcc::where('client_acc_id','=',$client_acc_id)->first();
        if(!$CysislbGtsClientAcc) return [
            'ok' => false,
            'msg' => 'CysislbGtsClientAcc missing data client_acc_id='.$client_acc_id,
        ];
        $TempIpoSummary = TempIpoSummary::where('client_acc_id','=',$client_acc_id)->first();
        if(!$TempIpoSummary) return [
            'ok' => false,
            'msg' => 'TempIpoSummary missing data client_acc_id='.$client_acc_id,
        ];
        // 已申購但未抽籤的新股。在途資金
        // $date = Carbon::parse($AccountReportSendingSummary['end_date'])->gt(Carbon::today())?Carbon::today():$AccountReportSendingSummary['end_date'];
        // $Subscription = A06::where('client_acc_id','=',$client_acc_id)
        //     ->whereDate('close_time','>=',$date)
        //     ->whereDate('allot_date','<',$date)->sum('amount');

        // 已中簽的新股
        $a06_alloted = A06::select('product_id','product_name','allot_price1','qty','amount')
            ->where('client_acc_id','=',$client_acc_id)
            ->whereDate('allot_date','>=',Carbon::today())
            ->whereNotIn('product_id',A05::where('client_acc_id','=',$client_acc_id)
            ->whereDate('buss_date','<',$AccountReportSendingSummary['end_date'])->get('product_id'))
            ->get('product_id','product_name','allot_price1','qty','amount');

        $Deposits = A01::select('buss_date','amount',DB::raw("case remark when 'OUT_TRANSFER' then '提款' else '入金' end as method"))
            ->where('client_acc_id','=',$client_acc_id)
            ->where('gl_mapping_item_id','=','OTH:Acct1')
            ->where(function ($query){
                $query->whereNull('remark')->orWhere(function ($query){
                $query->where('remark','=','OUT_TRANSFER')->where('ccy','=','HKD');
            });
        })->get()->toArray();
        for($i=0;$i<count($Deposits);$i++){
            $Deposits[$i]['avail_bal'] = $i?$Deposits[$i]['amount']+$Deposits[$i-1]['amount']:$Deposits[$i]['amount'];
        }

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
                // 'Subscription' => $Subscription,
                'Alloted_amount' => $a06_alloted->sum('amount'),
                'Alloted' => $a06_alloted->toArray(),
                'PortfolioMarketValue' => $a06_alloted->sum('amount'),
            ]
        ];
    }

    public function AnnualAccountReport(AccountReportSendingSummary $AccountReportSendingSummary, int $client_acc_id){
        $pdf = PDF::loadView('pdf.AnnualAccountReport', $this->AnnualAccountReportData($AccountReportSendingSummary, $client_acc_id));
        $pdf->setOptions(['isPhpEnabled' => true]);
        return ['ok'=>true,'msg'=>'','PDF'=>$pdf];
    }
}