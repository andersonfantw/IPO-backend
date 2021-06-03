<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeOfRenewal extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('email.NoticeOfRenewal')->subject('常設受權續期通知2021');
    }
}
