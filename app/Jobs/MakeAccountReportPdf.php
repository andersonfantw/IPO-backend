<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\AccountReportSendingSummary;
use App\AccountReport;
use App\ViewClient;
use App\Services\SiteDocumentService;

class MakeAccountReportPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $AccountReportSendingSummary;
    protected $AccountReport;
    protected $ViewClient;

    /**
     * Create a new job instance.
     *
     * @param int $account_report_sending_summary_id
     * @param int $client
     */
    public function __construct(int $account_report_sending_summary_id, int $client_acc_id)
    {
        $this->AccountReportSendingSummary = AccountReportSendingSummary::findOrFail($account_report_sending_summary_id);
        $this->AccountReport = AccountReport::where('account_report_sending_summary_id','=',$this->AccountReportSendingSummary->id)
            ->where('client_acc_id','=',$client_acc_id)->firstOrFail();
        $this->ViewClient = ViewClient::where('account_no','=',$client_acc_id)->firstOrFail();
        $this->AccountReport->report_queue_time = Carbon::now();
        $this->AccountReport->save();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->AccountReport->make_report_time = Carbon::now();
        $result = (new SiteDocumentService())->AnnualAccountReport($this->AccountReportSendingSummary,$this->AccountReport->client_acc_id);
        $this->AccountReport->make_report_status = $result['ok']?'success':'fail';
        if($result['ok']){
            $path = 'upload/'.$this->ViewClient->uuid.sprintf('/AnnualAccountReport[%s]_%s.pdf',$this->AccountReportSendingSummary['report_make_date']->format('YM'),$this->AccountReport->client_acc_id);
            Storage::put($path, $result['PDF']->output());
        }else{
            $this->AccountReport->remark = $result['msg'];
        }
        $this->AccountReport->save();
    }
}
