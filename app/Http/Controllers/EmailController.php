<?php

namespace App\Http\Controllers;

use App;
use App\Client;
use App\Mail\AccountOpened;
use App\SentEmailRecord;
use App\Traits\Score;
use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
{

    use Score;

    public function sendOpenAccountEmail(Request $request)
    {
        $clients = $request->input('clients');
        $User = $request->input('User');
        foreach ($clients as $client) {
            $Client = Client::where('uuid', $client['uuid'])->first();
            App::setLocale($Client->nationality);
            // $AyersAccount = $Client->AyersAccounts->where('type', '全權委託賬戶')->first();
            // $score = $Client->ViewClientScore->whereIn('type', ['age', 'education_level', 'client_investment_orientation'])->sum('score');
            // $score += $Client->ViewClientScore->whereNotIn('type', ['age', 'education_level', 'client_investment_orientation'])->max('score');
            // $data = [
            //     'account_name' => $Client->ViewClientIDCard->name_c,
            //     'account_no' => $AyersAccount->account_no,
            //     'account_type' => '現金/保證金賬戶(看客戶開戶選擇)/全權委託賬戶',
            //     'level' => $this->getLevel($score),
            //     'risk_tolerance' => $this->風險承受程度($score),
            // ];
            Mail::to($Client->email, $Client->ViewClientIDCard->name_c)->send(new AccountOpened($Client, $User));
            // Mail::send('email.OpenAccountEmail', $data, function ($message) use ($Client) {
            //     $message->to($Client->email, $Client->ViewClientIDCard->name_c)->subject('帳戶開戶通知書');
            //     $message->from('cs2@chinayss.hk', '中國銀盛國際證券有限公司');
            // });
            SentEmailRecord::create([
                'uuid' => $client['uuid'],
                'type' => 'open account email',
                'sent_by' => $User['name'],
            ]);
        }
    }
}
