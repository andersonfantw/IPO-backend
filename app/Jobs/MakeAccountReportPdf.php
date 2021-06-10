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
use Throwable;
use Exception;

class MakeAccountReportPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $AccountReport;

    /**
     * Create a new job instance.
     *
     * @param int $account_report_sending_summary_id
     * @param int $client
     */
    public function __construct(AccountReport $AccountReport)
    {
        $this->AccountReport = $AccountReport;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SiteDocumentService $SiteDocumentService)
    {
        $this->AccountReportSendingSummary = $this->AccountReport->AccountReportSendingSummary()->first();
        $this->ViewClient = ViewClient::where('account_no','=',$this->AccountReport->client_acc_id)->firstOrFail();
        $this->AccountReport->make_report_time = Carbon::now();
        $result = $SiteDocumentService->AnnualAccountReport($this->AccountReportSendingSummary,$this->AccountReport->client_acc_id);
        $this->AccountReport->make_report_status = $result['ok']?'success':'fail';
        if($result['ok']){
            // $path = 'upload/'.$this->ViewClient->uuid.sprintf('/AnnualAccountReport[%s]_%s.pdf',$this->AccountReportSendingSummary['report_make_date']->format('YM'),$this->AccountReport->client_acc_id);
            Storage::put(
                SiteDocumentService::getStoragePath(
                    $this->ViewClient->uuid,
                    $this->AccountReportSendingSummary['report_make_date'],
                    $this->AccountReport->client_acc_id
                ),
                $result['PDF']->output()
            );
        }else{
            $this->AccountReport->remark = $result['msg'];
        }
        $this->AccountReport->save();
    }

    public function failed(Exception $e){
        $this->AccountReport->make_report_status = 'fail';
        $this->AccountReport->make_report_time = Carbon::now();
        $this->AccountReport->remark = $e->getMessage();
        $this->AccountReport->save();
    }
}
