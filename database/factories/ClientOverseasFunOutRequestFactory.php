<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\ClientOverSeasFundOutRequest;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ClientOverSeasFundOutRequest::class, function (Faker $faker) {
    $Client = Client::where('mobile', '97149474')->first();
    $ClientAyersAccount08 = $Client->AyersAccounts()->orderBy('account_no', 'asc')->first();
    return [
        'uuid' => $Client->uuid,
        'account_out' => $ClientAyersAccount08->account_no,
        'bank' => '中國信託商業銀行',
        'amount' => mt_rand(1, 100) * 1000,
        'swift_code' => 'CTCBTWTP406',
        'account_in' => '4065' . mt_rand(1000000, 99999999),
        'bank_address' => '105台灣台北市松山區敦化北路122號',
        'bank_address_text' => '105台灣台北市松山區敦化北路122號',
        'status' => 'pending',
        'transfer_time' => Carbon::now()->toDatetimeString(),
        'timezone' => 8,
    ];
});
