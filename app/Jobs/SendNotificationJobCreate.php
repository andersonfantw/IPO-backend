<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\NotificationRecord;

class SendNotificationJobCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;
    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $NotificationRecord = NotificationRecord::ofParentID($this->id)->where(function($query){
            $query->whereNull('status')->orWhere('status','=','pending');
        })->get();
        foreach($NotificationRecord as $record){
            dispatch((new SendNotification($record->id))->onQueue('notification'));
        }
    }
}
