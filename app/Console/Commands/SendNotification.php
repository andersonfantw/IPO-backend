<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendNotificationJobCreate;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:sendall {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '執行通知任務';

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
        dispatch((new SendNotificationJobCreate($id))->onQueue('notification'));
        return 0;
    }
}
