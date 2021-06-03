<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeOnRenewalOfFullyAuthorizedDelegatedAccount extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('email.NoticeOnRenewalOfFullyAuthorizedDelegatedAccount')->subject('有關全權授權委託帳戶授權續期通知');
    }
}
