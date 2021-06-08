<?php

namespace App\Console\Commands;

use App\AccountReport;
use App\AccountReportSendingSummary;
use App\CysislbGtsClientAcc;
use App\ViewClient;
use App\Mail\AnnualAccountReport;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        $AccountReportSendingSummary = AccountReportSendingSummary::findOrFail($account_report_sending_summary_id);
        $AccountReport = AccountReport::where('account_report_sending_summary_id', '=', $account_report_sending_summary_id)->where('client_acc_id', '=', $this->argument('client'))->firstOrFail();
        $CysislbGtsClientAcc = CysislbGtsClientAcc::where('client_acc_id','=',$this->argument('client'))->firstOrFail();
        $ViewClient = ViewClient::where('account_no','=',$this->argument('client'))->firstOrFail();
        $attach_file = 'upload/'.$ViewClient->uuid.sprintf('/AnnualAccountReport[%s]_%s.pdf',$AccountReportSendingSummary['report_make_date']->format('YM'),$this->argument('client'));
        if(Storage::missing($attach_file)){
            $this->error(sprintf('AccountReport:SendTestMail id{%s}, client:%s, missing report file. Forgot to create pdf?', $account_report_sending_summary_id, $this->argument('client')));
            return 1;
        }
        // SendTest
        // SendAccountReportTestMail::dispatch($account_report_sending_summary_id,$this->argument('client'));
        $AccountReport->sending_queue_time = Carbon::now();
        $AccountReport->sending_status = 'pending';
        $AccountReport->save();
        $mailto = explode(',',env('MAIL_TO_OPERATOR'));
        Mail::to($mailto)->queue((new AnnualAccountReport([
            'client_name' => $CysislbGtsClientAcc->name,
            'client_acc_id' => $this->argument('client'),
            'report_date' => $AccountReportSendingSummary['report_make_date'],
            'email' => $CysislbGtsClientAcc->email,
            'attachFile' => $attach_file,
        ]))->onQueue('emails'));
        if(count(Mail::failures())>0){

        }else{
            
        }
        $this->line(sprintf('AccountReport:SendTestMail id{%s} client:%s',$this->argument('client'),$account_report_sending_summary_id));
        return 0;
    }
}
