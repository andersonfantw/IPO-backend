<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ViewClient;
use Carbon\Carbon;
use App\Models\ClientHkFundOutRequest;
use Faker\Generator as Faker;

$factory->define(ClientHkFundOutRequest::class, function (Faker $faker) {
    $method = ['收票人過戶支票','收票人現金支票','電子現金付款'];
    $row = ViewClient::where('mobile','=','55984928')->first();
    $rowClientAyersAccount08 = $row->ClientAyersAccount()->orderBy('account_no')->first();
    return [
        'uuid' => $row->uuid,
        'account_out' => $rowClientAyersAccount08->account_no,
        'bank' => '匯豐銀行',
        'amount' => mt_rand(1,100)*1000,
        'method' => $method[mt_rand(0,2)],
        'account_in' => '176'.mt_rand(10000000,999999999),
        'status' => 'pending',
        'transfer_time' => Carbon::now()->toDatetimeString(),
        'timezone' => 8
    ];
});
