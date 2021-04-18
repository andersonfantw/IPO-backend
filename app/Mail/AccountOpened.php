<?php

namespace App\Mail;

use App;
use App\Client;
use App\Traits\Score;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountOpened extends Mailable
{
    use Queueable, SerializesModels, Score;

    public $client;
    public $sender;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $client, array $sender)
    {
        $this->client = $client;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        App::setLocale($this->client->nationality);
        $AyersAccount = $this->client->AyersAccounts->where('type', '全權委託賬戶')->first();
        $score = $this->client->ViewClientScore->sum('score');
        $data = [
            'account_name' => $this->client->ViewClientIDCard->name_c,
            'account_no' => $AyersAccount->account_no,
            'account_type' => '現金/保證金賬戶(看客戶開戶選擇)/全權委託賬戶',
            'level' => $this->getLevel($score),
            'risk_tolerance' => $this->風險承受程度($score),
        ];
        return $this->view('email.OpenAccountEmail')->subject('帳戶開戶通知書')->with($data);
    }
}
