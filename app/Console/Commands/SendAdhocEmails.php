<?php

namespace App\Console\Commands;

use App\Imports\ChunkReadEmails;
use Excel;
use Illuminate\Console\Command;

class SendAdhocEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adhocemails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SendAdhocEmails';

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
        Excel::import(new ChunkReadEmails, storage_path('app/Emails.xls'));
        return 0;
    }
}
