<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AE;
use Illuminate\Support\Str;

class CreateAECode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aecode:create {name} {account_type : 08,13} {code}';

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
        $uuid = Str::uuid();
        $name = $this->argument('name');
        $account_type = $this->argument('account_type');
        $code = $this->argument('code');
        AE::updateOrCreate(
            ['uuid' => $uuid],
            [
                'name' => $name,
                'account_type' => $account_type,
                'code' => $code,
            ]
        );
        return 0;
    }
}
