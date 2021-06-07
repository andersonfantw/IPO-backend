<?php

namespace App\Console\Commands;

use App\AccountReport;
use App\Jobs\SendAccountReportTestMail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AccountReportSendTestMail extends Command
{
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
        $AccountReport = AccountReport::where('account_report_sending_summary_id', '=', $account_report_sending_summary_id)->where('client_acc_id', '=', $this->option('client'))->first();
        if (empty($AccountReport)) $this->line(sprintf('AccountReport:SendTestMail client:%s is not in id{%s}', $this->option('client'), $account_report_sending_summary_id));
        else {
            // SendTest
            SendAccountReportTestMail::dispatch($account_report_sending_summary_id,$this->option('client'));
            $this->line(sprintf('AccountReport:SendTestMail id{%s} client:%s',$this->option('client'),$account_report_sending_summary_id));
        }
        return 0;
    }
}
