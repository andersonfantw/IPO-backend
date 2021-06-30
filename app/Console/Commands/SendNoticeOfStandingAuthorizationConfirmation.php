<?php

namespace App\Console\Commands;

use App\Imports\ChunkReadEmailsForNoticeOfStandingAuthorizationConfirmation;
use Excel;
use Illuminate\Console\Command;

class SendNoticeOfStandingAuthorizationConfirmation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NoticeOfStandingAuthorizationConfirmation:send';

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
        Excel::import(new ChunkReadEmailsForNoticeOfStandingAuthorizationConfirmation, storage_path('app/20210629確認信名單.xls'));
        return 0;
    }
}
