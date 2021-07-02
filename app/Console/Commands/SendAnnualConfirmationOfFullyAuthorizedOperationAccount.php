<?php

namespace App\Console\Commands;

use App\Imports\ChunkReadEmailsForAnnualConfirmationOfFullyAuthorizedOperationAccount;
use Excel;
use Illuminate\Console\Command;

class SendAnnualConfirmationOfFullyAuthorizedOperationAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AnnualConfirmationOfFullyAuthorizedOperationAccount:send';

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
        Excel::import(new ChunkReadEmailsForAnnualConfirmationOfFullyAuthorizedOperationAccount, storage_path('app/20210702確認信名單.xls'));
        return 0;
    }
}
