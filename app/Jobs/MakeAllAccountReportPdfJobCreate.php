<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use App\AccountReport;


class MakeAllAccountReportPdfJobCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;
    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $AccountReport = AccountReport::ofParentID($this->id)->where(function($query){
            $query->whereNull('make_report_status')->orWhere('make_report_status','=','pending');
        })->get();
        foreach($AccountReport as $account){
            Artisan::call('AccountReport:MakePdf', [
                'id'=>$this->id,
                '--client'=>$account->client_acc_id
            ]);
        }
    }
}
