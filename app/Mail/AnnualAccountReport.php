<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnualAccountReport extends Mailable
{
    use Queueable, SerializesModels;

    protected $content;
    protected $sender;

    /**
     * Create a new message instance.
     *
     * array $content = [
     *      'client_name',
     *      'client_acc_id',
     *      'report_date',
     *      'email',
     *      'attachFile',
     * ]
     * @return void
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.AccountReport')
            ->subject(sprintf('CYSS專戶報告[%s]_%s',$this->content['report_date'],$this->content['client_acc_id']))
            ->with($this->content)
            ->attachFromStorage($this->content['attachFile']);
    }

    public function failed($e){
        var_dump(3,$e);
    }
}
