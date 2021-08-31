<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CommissionRecalculateJob;

class CommissionRecalculateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Commission:Recalculate {month}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '重新計算佣金';

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
        dispatch((new CommissionRecalculateJob($this->argument('month')))->onQueue('default'));
        return 0;
    }
}
