<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoReplyToNoticeOfRenewal extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('email.NoReplyToNoticeOfRenewal')->subject('(錯誤信息提醒) - 常設授權續期通知2021');
    }
}
