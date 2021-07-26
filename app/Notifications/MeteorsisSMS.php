<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Cuby\Meteorsis\MeteorsisMessage;
use App\Channels\MeteorsisChannel;
use App\Services\NotifyMessage;

class MeteorsisSMS extends Notification implements ShouldQueue
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
            MeteorsisChannel::class => 'notify',
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
        return [MeteorsisChannel::class];
    }

    /**
     * Get the Meteorsis representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \cuby\meteorsis\MeteorsisMessage
     */
    public function toMeteorsis($notifiable)
    {
        $data = $this->NotifyMessage->toData();
        return (new MeteorsisMessage)
            ->title('CYSS')
            ->content($data['content'])
            ->unicode()->at('now');
    }

    /**
     * 回傳NotificationRecord.id
     *
     * @return string
     */
    public function getRecordId(): string
    {
        return $this->NotifyMessage->record_id;
    }
}
