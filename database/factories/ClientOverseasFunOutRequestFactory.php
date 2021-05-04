<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ViewClient;
use Carbon\Carbon;
use App\Models\ClientOverSeasFundOutRequest;
use Faker\Generator as Faker;

$factory->define(ClientOverSeasFundOutRequest::class, function (Faker $faker) {
    $row = ViewClient::where('mobile','=','55984928')->first();
    $rowClientAyersAccount08 = $row->ClientAyersAccount()->orderBy('account_no')->first();
    return [
        'uuid' => $row->uuid,
        'account_out' => $rowClientAyersAccount08->account_no,
        'bank' => '中國信託商業銀行',
        'amount' => mt_rand(1,100)*1000,
        'swift_code' => 'CTCBTWTP406',
        'account_in' => '4065'.mt_rand(1000000,99999999),
        'bank_address' => '105台灣台北市松山區敦化北路122號',
        'bank_address_text',
        'status' => 'pending',
        'transfer_time' => Carbon::now()->toDatetimeString(),
        'timezone' => 8
    ];
});
