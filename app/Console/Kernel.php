<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // ImportA07::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('a07:import')->runInBackground();
        $schedule->command('ayers:importall today All')->dailyAt('23:30');
        $schedule->call(function(){
            dispatch((new \App\Jobs\UpdateA01ProductId)->onQueue('AyersCSVImport'));
            //dispatch((new \App\Jobs\UpdateRelayTable)->onQueue('AyersCSVImport'));
            dispatch((new \App\Jobs\ReflashIpoSummary)->onQueue('AyersCSVImport'));
        })->dailyAt('23:35');
        $schedule->call(function(){
            (new AuditClientController)->NoticeClientCorrectToRejectItemOn5days();
        })->dailyAt('12:30');
        $schedule->call(function(){
            dispatch((new \App\Jobs\CommissionRecalculateJob((new Carbon('first day of this month'))->format('Y-m-d')))->onQueue('default'));
        })->dailyAt('12:40');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
