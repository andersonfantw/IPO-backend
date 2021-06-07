<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AccountReportSendTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AccountReport:SendTestMail';

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
        return 0;
    }
}
