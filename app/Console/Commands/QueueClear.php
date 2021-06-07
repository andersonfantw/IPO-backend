<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Redis;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class QueueClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:clear {name=default : default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear Queued jobs';

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
        $name = 'default';
        if($this->argument('name')!='') $name = $this->argument('name');
        Redis::connection()->del(['queues:'.$name]);
        Artisan::call('queue:restart');
        return 0;
    }
}
