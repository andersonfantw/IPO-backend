<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\ClientFundInRequest;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ClientFundInRequest::class, function (Faker $faker) {
    $methods = ['收票人過戶支票', '收票人現金支票', '電子現金付款'];
    // $banks = ['匯豐銀行', '中國銀行', '東亞銀行'];
    $Client = Client::where('mobile', '97149474')->first();
    $ClientAyersAccount08 = $Client->AyersAccounts()->orderBy('account_no')->first();
    return [
        'uuid' => $Client->uuid,
        'account_no' => $ClientAyersAccount08->account_no,
        'bank' => '匯豐銀行',
        'amount' => mt_rand(1, 100) * 1000,
        'method' => $methods[mt_rand(0, 2)],
        'status' => 'pending',
        'transfer_time' => Carbon::now()->toDatetimeString(),
        'timezone' => 8,
        'receipt' => '',
    ];
});
