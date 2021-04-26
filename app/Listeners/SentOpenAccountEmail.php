<?php

namespace App\Listeners;

use App\SentEmailRecord;
use Illuminate\Mail\Events\MessageSent;

class SentOpenAccountEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $client = $event->data['client'];
        $sender = $event->data['sender'];
        SentEmailRecord::create([
            'uuid' => $client->uuid,
            'type' => 'open account email',
            'sent_by' => $sender['name'],
        ]);
    }
}
