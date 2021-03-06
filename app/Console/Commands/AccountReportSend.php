<?php

namespace App\Console\Commands;

use App\AccountReport;
use App\AccountReportSendingSummary;
use App\Jobs\SendAccountReport;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\SendAllAccountReportJobCreate;

class AccountReportSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AccountReport:send {id} {--client=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '寄出專戶年報檔';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $account_report_sending_summary_id = $this->argument('id');
        if($this->option('client')=='all') {
            SendAllAccountReportJobCreate::dispatch($account_report_sending_summary_id)->onQueue('command');
        }else {
            $AccountReportSendingSummary = AccountReportSendingSummary::findOrFail($account_report_sending_summary_id);
            $AccountReport = AccountReport::where('account_report_sending_summary_id', '=', $account_report_sending_summary_id)->where('client_acc_id', '=', $this->option('client'))->first();
            if (empty($AccountReport)) $this->error(sprintf('AccountReport:send id{%s}, client:%s is not exists!', $account_report_sending_summary_id, $this->option('client')));
            else {
                $AccountReport->sending_queue_time = Carbon::now();
                $AccountReport->sending_status = 'pending';
                $AccountReport->save();
                // send
                dispatch((new SendAccountReport($AccountReport))->onQueue('email'));

                $this->line(sprintf('AccountReport:send id{%s} client:%s',$this->option('client'),$account_report_sending_summary_id));
            }
        }
        return 0;
    }
}
