<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\AccountReport;
use App\Mail\AnnualAccountReport;
use Carbon\Carbon;

class SendAccountReportTestMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $AccountReport;

    /**
     * Create a new job instance.
     *
     * @return void
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
    public function handle()
    {
        $account_report_sending_summary_id = $this->AccountReport->account_report_sending_summary_id;
        $client_acc_id = $this->AccountReport->client_acc_id;
        $AccountReportSendingSummary = $this->AccountReport->AccountReportSendingSummary()->first();
        $CysislbGtsClientAcc = $this->AccountReport->ViewClient()->first();
        $ViewClient = $this->AccountReport->ViewClient()->first();

        $attach_file = 'upload/'.$ViewClient->uuid.sprintf('/AnnualAccountReport[%s]_%s.pdf',$AccountReportSendingSummary->report_make_date->format('YM'),$client_acc_id);
        if(Storage::missing($attach_file)) abort(404);

        Mail::to(explode(',',env('MAIL_TO_OPERATOR')))
        ->send((new AnnualAccountReport([
            'client_name' => $CysislbGtsClientAcc->name,
            'client_acc_id' => $client_acc_id,
            'report_date' => $AccountReportSendingSummary->report_make_date,
            'email' => $CysislbGtsClientAcc->email,
            'attachFile' => $attach_file,
        ])));
    }
}
