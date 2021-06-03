<?php

namespace App\Console\Commands;

use App\Imports\ChunkReadEmailsForNoticeOfRenewal;
use Excel;
use Illuminate\Console\Command;

class SendNoticeOfRenewalEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NoticeOfRenewalEmail:send';

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
        Excel::import(new ChunkReadEmailsForNoticeOfRenewal, storage_path('app/LIST.xls'));
        return 0;
    }
}
