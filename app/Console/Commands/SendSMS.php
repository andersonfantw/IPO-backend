<?php

namespace App\Console\Commands;

use App\Imports\ChunkReadListOfCustomersWhoFailedToPay;
use Excel;
use Illuminate\Console\Command;

class SendSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SMS:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Excel::import(new ChunkReadListOfCustomersWhoFailedToPay, storage_path('app/Rejected20210702.xls'));
        return 0;
    }
}
