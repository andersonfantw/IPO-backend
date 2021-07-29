<?php

namespace App\Http\Controllers;

use App;
use App\Client;
use App\Services\NotifyMessage;
use App\Services\NotifyService;
use App\Traits\Score;
use Illuminate\Http\Request;

class EmailController extends Controller
{

    use Score;

    public function sendOpenAccountEmail(Request $request)
    {
        $clients = $request->input('clients');
        $User = $request->input('User');
        foreach ($clients as $client) {
            $Client = Client::with(['IDCard', 'AyersAccounts'])->where('uuid', $client['uuid'])->first();
            $account_no = $Client->AyersAccounts->first()->account_no;
            $client_id = substr($account_no, 0, -2);
            // $client_id = '200001';
            // Mail::to($Client->email, $Client->IDCard->name_c)->send(new AccountOpened($Client, $User));
            $account_no = [];
            $account_type = [];
            foreach ($Client->AyersAccounts as $AyersAccount) {
                $account_no[] = $AyersAccount->account_no;
                $account_type[] = $AyersAccount->type;
            }
            $score = $Client->ViewClientScore->sum('score');
            $params = [
                'account_name' => $Client->IDCard->name_c,
                'account_no' => implode(", ", $account_no),
                'account_type' => implode(", ", $account_type),
                'level' => $this->getLevel($score),
                'risk_tolerance' => $this->風險承受程度($score),
            ];
            (new NotifyService)->notify((new NotifyMessage)->clientId($client_id)->params($params)->templateId(7)->title('帳戶開戶通知書'));
        }
    }
}
