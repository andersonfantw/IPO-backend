<?php

namespace App\Console\Commands;

use App\Jobs\MakeAllAccountReportPdf;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\AccountReport;
use App\AccountReportSendingSummary;
use App\Jobs\MakeAccountReportPdf;

class AccountReportMakePdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AccountReport:MakePdf {id} {--client=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '產出專戶年報檔';

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
        if($this->option('client')=='all'){
            // 新增所有client_acc_id
            MakeAllAccountReportPdf::dispatch($account_report_sending_summary_id)->onQueue('command');
        }else{
            $AccountReport= AccountReport::ofParentID($account_report_sending_summary_id)->where('client_acc_id','=',$this->option('client'))->first();
            if(empty($AccountReport)) $this->error(sprintf('AccountReport:MakePdf id{%s}, client:%s is not exists!',$account_report_sending_summary_id,$this->option('client')));
            else{
                $AccountReport->report_queue_time = Carbon::now();
                $AccountReport->make_report_status = 'pending';
                $AccountReport->save();
                MakeAccountReportPdf::dispatch($AccountReport)->onQueue('report');
                $this->line(sprintf('AccountReport:MakePdf id{%s} client:%s',$account_report_sending_summary_id,$this->option('client')));
            }
        }
        return 0;
    }
}
