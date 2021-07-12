<?php

namespace App\Console\Commands;

use App\Client;
use App\Traits\Report;
use Illuminate\Console\Command;

class GenerateAccountOpeningForm extends Command
{
    use Report;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AccountOpeningForm:generate';

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
        $Clients = Client::has('AyersAccounts')->where('type', '拼一手')->get();
        foreach ($Clients as $Client) {
            $this->AccountOpeningForm($Client);
            dump($Client->uuid);
            dump($Client->IDCard->name_c);
        }
        return 0;
    }
}
