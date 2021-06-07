<?php

namespace App\Jobs;

use PDF;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\AccountReportSendingSummary;
use App\ViewClient;
use App\CysislbGtsClientAcc;
use App\TempIpoSummary;
use App\AccountReport;
use App\A06;
use App\A05;
use App\A01;
use Illuminate\Support\Facades\DB;
use App\Traits\Report;

class MakeAccountReportPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Report;

    protected $account_report_sending_summary_id;
    protected $client_acc_id;

    /**
     * Create a new job instance.
     *
     * @param int $account_report_sending_summary_id
     * @param int $client
     */
    public function __construct(int $account_report_sending_summary_id, int $client_acc_id)
    {
        $this->account_report_sending_summary_id = $account_report_sending_summary_id;
        $this->client_acc_id = $client_acc_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $AccountReportSendingSummary = AccountReportSendingSummary::find($this->account_report_sending_summary_id);
        if(!$AccountReportSendingSummary){
            return;
        }
        $AccountReport = AccountReport::where('account_report_sending_summary_id','=',$AccountReportSendingSummary->id)
            ->where('client_acc_id','=',$this->client_acc_id)->first();
        if(!$AccountReport){
            return;
        }
        $AccountReport->make_report_time = Carbon::now();
        $AccountReport->save();
        $ViewClient = ViewClient::where('account_no','=',$this->client_acc_id);
        if(!$ViewClient){
            $AccountReport->make_report_status = 'fail';
            $AccountReport->remark = 'ViewClient missing data account_no='.$this->client_acc_id;
            $AccountReport->save();
            return;
        }
        $CysislbGtsClientAcc = CysislbGtsClientAcc::where('client_acc_id','=',$this->client_acc_id)->first();
        if(!$CysislbGtsClientAcc){
            $AccountReport->make_report_status = 'fail';
            $AccountReport->remark = 'CysislbGtsClientAcc missing data client_acc_id='.$this->client_acc_id;
            $AccountReport->save();
            return;
        }
        $TempIpoSummary = TempIpoSummary::where('client_acc_id','=',$this->client_acc_id)->first();
        if(!$TempIpoSummary){
            $AccountReport->make_report_status = 'fail';
            $AccountReport->remark = 'TempIpoSummary missing data client_acc_id='.$this->client_acc_id;
            $AccountReport->save();
            return;
        }
        // 已申購但未抽籤的新股
        $date = Carbon::parse($AccountReportSendingSummary['end_date'])->gt(Carbon::today())?Carbon::today():$AccountReportSendingSummary['end_date'];
        $Subscription = A06::where('client_acc_id','=',$this->client_acc_id)
            ->whereDate('close_time','>=',$date)
            ->whereDate('allot_date','<',$date)->sum('amount');
        if(!$Subscription){
            $AccountReport->make_report_status = 'fail';
            $AccountReport->remark = 'A06(1) missing data client_acc_id='.$this->client_acc_id;
            $AccountReport->save();
            return;
        }
        // 已中簽的新股
        $a06_alloted = A06::where('client_acc_id','=',$this->client_acc_id)
            ->whereDate('allot_date','>=',Carbon::today())
            ->whereNotIn('product_id',A05::where('client_acc_id','=',$this->client_acc_id)
            ->whereDate('buss_date','<',$AccountReportSendingSummary['end_date'])->get('product_id'))
            ->get('product_id','product_name','allot_price1','qty','amount');
        if(!$a06_alloted){
            $AccountReport->make_report_status = 'fail';
            $AccountReport->remark = 'A06(2) missing data client_acc_id='.$this->client_acc_id;
            $AccountReport->save();
            return;
        }

        $Deposits = A01::select('buss_date','amount',DB::raw("case remark when 'OUT_TRANSFER' then '提款' else '入金' end as method"))
            ->where('client_acc_id','=',$this->client_acc_id)
            ->where('gl_mapping_item_id','=','OTH:Acct1')
            ->where(function ($query){
                $query->whereNull('remark')->orWhere(function ($query){
                $query->where('remark','=','OUT_TRANSFER')->where('ccy','=','HKD');
            });
        })->get();
        if(!$Deposits){
            $AccountReport->make_report_status = 'fail';
            $AccountReport->remark = 'A01 missing data client_acc_id='.$this->client_acc_id;
            $AccountReport->save();
            return;
        }

        $section3 = $AccountReportSendingSummary->report;
        $pdf = PDF::loadView('pdf.AnnualAccountReport',[
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
        ]);
        $pdf->setOptions(['isPhpEnabled' => true]);
        $path = 'upload/'.$ViewClient->uuid.sprintf('/AnnualAccountReport_%s.pdf',$AccountReportSendingSummary['report_make_date']->format('Ymd'));
        $pdf->save($path);
        $AccountReport->make_report_status = 'success';
        $AccountReport->save();
    }
}
