<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendAccountReport implements ShouldQueue
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
        $AccountReportSendingSummary = $this->AccountReport->AccountReportSendingSummary()->firstOrFail();
        $CysislbGtsClientAcc = $this->AccountReport->ViewClient()->firstOrFail();
        $ViewClient = $this->AccountReport->ViewClient()->firstOrFail();

        $attach_file = 'upload/'.$ViewClient->uuid.sprintf('/AnnualAccountReport[%s]_%s.pdf',$AccountReportSendingSummary->report_make_date->format('YM'),$client_acc_id);
        if(Storage::missing($attach_file)){
            $this->error(sprintf('AccountReport:SendTestMail id{%s}, client:%s, missing report file. Forgot to create pdf?', $account_report_sending_summary_id, $client_acc_id));
            return 1;
        }

        Mail::to(explode(',',env('MAIL_TO_OPERATOR')))
        ->send((new AnnualAccountReport([
            'client_name' => $CysislbGtsClientAcc->name,
            'client_acc_id' => $client_acc_id,
            'report_date' => $AccountReportSendingSummary->report_make_date,
            'email' => $CysislbGtsClientAcc->email,
            'attachFile' => $attach_file,
        ])));
        $this->AccountReport->sending_time = Carbon::now();
        if (count(Mail::failures()) > 0) {
            $this->AccountReport->sending_status = 'fail';
            $this->AccountReport->save();
        }else{
            $this->AccountReport->sending_status = 'success';
            $this->AccountReport->save();
        }
    }

    public function failed(Throwable $exception){
        $this->AccountReport->sending_status = 'fail';
        $this->AccountReport->sending_time = Carbon::now();
        $this->AccountReport->save();
    }
}
