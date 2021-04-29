<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientAyersAccount;
use App\Traits\Report;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AyersAccountController extends Controller
{
    use Report;

    public function generate(Request $request)
    {
        $clients = $request->input('clients');
        foreach ($clients as $client) {
            try {
                $ClientAyersAccount = ClientAyersAccount::where('uuid', $client['uuid'])->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $account_no = ClientAyersAccount::whereRaw('LENGTH(account_no) > ?', [8])->max('account_no');
                if ($account_no) {
                    $account_no = preg_replace('/\d\d$/i', '', $account_no);
                    $account_no = intval($account_no) + 1;
                } else {
                    $account_no = 200000;
                }
                ClientAyersAccount::create([
                    'uuid' => $client['uuid'],
                    'account_no' => "{$account_no}08",
                    'type' => '現金賬戶',
                ]);
                ClientAyersAccount::create([
                    'uuid' => $client['uuid'],
                    'account_no' => "{$account_no}13",
                    'type' => '全權委託賬戶',
                ]);
                $Client = Client::where('uuid', $client['uuid'])->first();
                $this->AccountOpeningForm($Client);
            }
        }
        // return redirect()->route($request->input('redirect_route'));
    }
}
