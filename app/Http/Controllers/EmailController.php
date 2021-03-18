<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        App::setLocale('zh-hk');
        $data = [
            'account_name' => 'LTW',
            'account_no' => 1234513,
            'account_type' => '現金/保證金賬戶(看客戶開戶選擇)/全權委託賬戶',
            'level' => 4,
            'risk_tolerance' => '高',
        ];
        Mail::send('Email', $data, function ($message) {
            $message->to('leetszwa04@gmail.com', '中國銀盛國際證券有限公司')->subject('帳戶開戶通知書');
            $message->from('cs2@chinayss.hk', '中國銀盛國際證券有限公司');
        });
    }
}
