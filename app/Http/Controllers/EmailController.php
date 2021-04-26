<?php

namespace App\Http\Controllers;

use App;
use App\Client;
use App\Mail\AccountOpened;
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
            // App::setLocale($Client->nationality);
            Mail::to($Client->email, $Client->ViewClientIDCard->name_c)->send(new AccountOpened($Client, $User));
        }
    }
}
