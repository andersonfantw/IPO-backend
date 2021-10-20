<?php
namespace App\Channels;

use Cuby\Meteorsis\MeteorsisService;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Channels\MailChannel;
use App\Models\NotificationRecord;
use Carbon\Carbon;

class CYSSMailChannel extends MailChannel
{
    /**
     * Undocumented function
     *
     * @param [type] $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        parent::send($notifiable,$notification);
        $NotificationRecord = NotificationRecord::find($notification->getRecordId());
        $NotificationRecord->status = 'success';
        $NotificationRecord->sending_time = Carbon::now();
        $NotificationRecord->save();
    }
}