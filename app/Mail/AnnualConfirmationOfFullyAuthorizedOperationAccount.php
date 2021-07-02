<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnualConfirmationOfFullyAuthorizedOperationAccount extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('email.全權委託授權操作賬戶之年度確認')->subject('全權委託授權操作賬戶之年度確認');
    }
}
