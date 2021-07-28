<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Services\NotifyMessage;

class AccountOverview extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param NotifyMessage $NotifyMessage
     */
    public function __construct(NotifyMessage $NotifyMessage)
    {
        $this->NotifyMessage = $NotifyMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $data = $this->NotifyMessage->toData();
        return [
            'title' => $data['title'],
            'content' => $data['content'],
            'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
