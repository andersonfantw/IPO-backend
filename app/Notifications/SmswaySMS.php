<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Cuby\Smsway\SmswayMessage;
use App\Channels\SmswayChannel;
use App\Services\NotifyMessage;

class SmswaySMS extends Notification implements ShouldQueue
{
    use Queueable;

    private $NotifyMessage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(NotifyMessage $NotifyMessage)
    {
        $this->NotifyMessage = $NotifyMessage;
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            SmswayChannel::class => 'notify',
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmswayChannel::class];
    }

    /**
     * Get the Smsway representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \cuby\Smsway\SmswayMessage
     */
    public function toSmsway($notifiable)
    {
        $data = $this->NotifyMessage->toData();
        return (new SmswayMessage)
            ->content($data['content']);
    }

    /**
     * 回傳NotificationRecord.id
     *
     * @return string
     */
    public function getRecordId(): string
    {
        return $this->NotifyMessage->getRecordId();
    }

    public function getMobile(): string
    {
        return $this->NotifyMessage->getMobile();
    }
}
