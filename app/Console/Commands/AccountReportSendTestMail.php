<?php

namespace App\Console\Commands;

use App\AccountReport;
use App\ViewClient;
use App\Jobs\SendAccountReportTestMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class AccountReportSendTestMail extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AccountReport:SendTestMail {id} {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '寄出專戶年報檔至測試信箱';

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
        $AccountReport = AccountReport::where('account_report_sending_summary_id', '=', $account_report_sending_summary_id)
            ->where('client_acc_id', '=', $this->argument('client'))->firstOrFail();

        dispatch((new SendAccountReportTestMail($AccountReport))->onQueue('email'));

        $this->line(sprintf('AccountReport:SendTestMail id{%s} client:%s',$this->argument('client'),$account_report_sending_summary_id));
        return 0;
    }
}
