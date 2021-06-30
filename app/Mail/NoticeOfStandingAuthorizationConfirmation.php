<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeOfStandingAuthorizationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('email.常設受權確認通知')->subject('常設受權確認通知');
    }
}
