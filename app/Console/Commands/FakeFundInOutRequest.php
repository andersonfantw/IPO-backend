<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FakeFundInOutRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker:transfer {name}';

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
        switch ($this->argument('name')) {
            case 'in':
                factory(\App\ClientFundInRequest::class, 1)->create();
                break;
            case 'out':
                factory(\App\ClientHkFundOutRequest::class, 1)->create();
                break;
            case 'oversea':
                factory(\App\ClientOverSeasFundOutRequest::class, 1)->create();
                break;
            case 'internal':
                factory(\App\ClientFundInternalTransferRequest::class, 1)->create();
                break;
        }
        return 0;
    }
}
