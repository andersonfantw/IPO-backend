<?php
namespace App\Channels;

use Cuby\Meteorsis\MeteorsisService;
use Illuminate\Notifications\Notification;
use App\Notifications\MeteorsisSMS;
use App\NotificationRecord;
use Carbon\Carbon;

class MeteorsisChannel
{
    /**
     * Undocumented function
     *
     * @param [type] $notifiable
     * @param MeteorsisSMS $notification
     * @return void
     */
    public function send($notifiable, MeteorsisSMS $notification)
    {
        $mobile = (method_exists($notifiable,'routeNotificationForMeteorsis'))
            ?$notifiable->routeNotificationFor('Meteorsis')
            :$notification->getMobile();
        $message = $notification->toMeteorsis($notifiable);
        $result = (new MeteorsisService())->send($message->recipient($mobile));
        // $result = ['SMSDID'=>123456];
        $NotificationRecord = NotificationRecord::find($notification->getRecordId());
        $NotificationRecord->status = array_key_exists('SMSDID',$result)?'success':'failure';
        $NotificationRecord->remark = json_encode($result);
        $NotificationRecord->sending_time = Carbon::now();
        $NotificationRecord->save();
    }
}