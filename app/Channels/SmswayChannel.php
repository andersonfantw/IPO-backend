<?php
namespace App\Channels;

use Cuby\Smsway\SmswayService;
use Illuminate\Notifications\Notification;
use App\Notifications\SmswaySMS;
use App\Models\NotificationRecord;
use Carbon\Carbon;

class SmswayChannel
{
    /**
     * Undocumented function
     *
     * @param [type] $notifiable
     * @param SmswaySMS $notification
     * @return void
     */
    public function send($notifiable, SmswaySMS $notification)
    {
        $mobile = (method_exists($notifiable,'routeNotificationForSmsway'))
            ?$notifiable->routeNotificationFor('Smsway')
            :$notification->getMobile();
        $message = $notification->toSmsway($notifiable);
        $result = (new SmswayService())->send($message->recipient($mobile));
        // $result = ['SMSDID'=>123456];
        $NotificationRecord = NotificationRecord::find($notification->getRecordId());
        $NotificationRecord->status = (($result['status']??100)==0)?'success':'failure';
        $NotificationRecord->remark = json_encode($result);
        $NotificationRecord->sending_time = Carbon::now();
        $NotificationRecord->save();
    }
}