<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\ClientHkFundOutRequest;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ClientHkFundOutRequest::class, function (Faker $faker) {
    $method = ['收票人過戶支票', '收票人現金支票', '電子現金付款'];
    $Client = Client::where('mobile', '97149474')->first();
    $ClientAyersAccount08 = $Client->AyersAccounts()->orderBy('account_no', 'asc')->first();
    return [
        'uuid' => $Client->uuid,
        'account_out' => $ClientAyersAccount08->account_no,
        'bank' => '匯豐銀行',
        'amount' => mt_rand(1, 100) * 1000,
        'method' => $method[mt_rand(0, 2)],
        'account_in' => '176' . mt_rand(10000000, 999999999),
        'status' => 'pending',
        'transfer_time' => Carbon::now()->toDatetimeString(),
        'timezone' => 8,
    ];
});
