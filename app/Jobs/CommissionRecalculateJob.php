<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\AE;

class CommissionRecalculateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;
    private $month;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $month)
    {
        $this->month = $month;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $AE = AE::select('name','uuid')
            ->selectRaw("group_concat(code) as codes")
            ->groupBy('uuid','name')
            ->first()->toArray();
        if($AE['name']=='梧桐花開'){
            $AE['name']='王浩進';
            $AE['codes'] = $AE['codes'].',AEWHC';
        }
        $end = Carbon::parse($this->month)->endOfMonth()->format('Y-m-d');
        foreach($AE as $row){
            DB::select(sprintf("call sp_ae_commission('%s','%s','%s','%s')",$row['uuid'],$row['codes'],$this->month,$end));
        }
    }
}
