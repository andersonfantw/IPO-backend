<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\MeteorsisSMS;
use App\Notifications\SmswaySMS;
use App\Notifications\CYSSMail;
use App\Notifications\AccountOverview;
use App\Services\NotifyMessage;
use App\Models\NotificationGroup;
use App\Models\NotificationRecord;
use CubyBase\Common\Phone;
use Carbon\Carbon;

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
     * 此時的title和content已經換過參數
     *
     * @return void
     */
    public function handle()
    {
        $NotificationGroup = NotificationGroup::findOrFail($this->id);
        $NotificationRecord = NotificationRecord::ofParentID($this->id)->where(function($query){
            $query->whereNull('status')->orWhere('status','=','pending');
        })->get();
        switch($NotificationGroup->route){
            case 'sms':
            case 'alloted_notice':
                foreach($NotificationRecord as $record){
                    $record->queue_time = Carbon::now();
                    $record->save();
                    $message = (new NotifyMessage)->modelNotificationRecord($record);
                    if(Phone::create($message->getMobile())->format('c')=='86'){
                        $record->notify(new SmswaySMS($message));
                    }else{
                        $record->notify(new MeteorsisSMS($message));
                    }
                }
                break;
            case 'email':
                foreach($NotificationRecord as $record){
                    sleep(1);
                    $record->queue_time = Carbon::now();
                    $record->save();
                    $record->notify(new CYSSMail((new NotifyMessage)->modelNotificationRecord($record)));
                }
                break;
            case 'account_overview':
                foreach($NotificationRecord as $record){
                    $record->queue_time = Carbon::now();
                    $record->save();
                    $record->notify(new AccountOverview((new NotifyMessage)->modelNotificationRecord($record)));
                }
                break;
        }
    }
}
