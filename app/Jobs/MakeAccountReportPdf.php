<?php

namespace App\Jobs;

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

class MakeAccountReportPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $account_report_sending_summary_id;
    protected $client;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(integer $account_report_sending_summary_id, integer $client)
    {
        $this->account_report_sending_summary_id = $account_report_sending_summary_id;
        $this->client = $client;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $AccountReportSendingSummary = AccountReportSendingSummary::find($this->account_report_sending_summary_id);
        $ViewClient = ViewClient::where('account_no','=',$this->client_acc_id);
        $CysislbGtsClientAcc = CysislbGtsClientAcc::where('client_acc_id','=',$this->client_acc_id)->first();
        $TempIpoSummary = TempIpoSummary::where('client_acc_id','=',$this->client_acc_id)->first();
        $AccountReport = AccountReport::where('account_report_sending_summary_id','=',$AccountReportSendingSummary->id)->where('client_acc_id','=',$this->client_acc_id)->first();
        // 已申購但未抽籤的新股
        $date = Carbon::parse($AccountReportSendingSummary['end_date'])->gt(Carbon::today())?Carbon::today():$AccountReportSendingSummary['end_date'];
        $Subscription = A06::where('client_acc_id','=',$this->client_acc_id)->whereDate('close_time','>=',$date)->whereDate('allot_date','<',$date)->sum('amount');
        // 已中簽的新股
        $a06_alloted = A06::where('client_acc_id','=',$this->client_acc_id)
        ->whereDate('allot_date','>=',Carbon::today())
        ->whereNotIn('product_id',A05::where('client_acc_id','=',$this->client_acc_id)->whereDate('buss_date','<',$AccountReportSendingSummary['end_date'])->get('product_id'))
        ->get('product_id','product_name','allot_price1','qty','amount');

        $Deposits = A01::select('buss_date','amount',DB::raw("case remark when 'OUT_TRANSFER' then '提款' else '入金' end as method"))->where('client_acc_id','=',$this->client_acc_id)->where('gl_mapping_item_id','=','OTH:Acct1')->where(function ($query){
            $query->whereNull('remark')->orWhere(function ($query){
                $query->where('remark','=','OUT_TRANSFER')->where('ccy','=','HKD');
            });
        })->get();

        $section3 = $AccountReportSendingSummary->report;
        $pdf = PDF::loadView('pdf.AnnualAccountReport',$this->prepareDocData([
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
        $path = 'upload/'.auth()->user()->uuid.sprintf('/AnnualAccountReport_%s.pdf',$AccountReportSendingSummary['report_make_date']->format('Ymd'));
        $pdf->save($path);
    }
}
