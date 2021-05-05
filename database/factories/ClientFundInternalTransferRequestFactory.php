<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\ClientFundInternalTransferRequest;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ClientFundInternalTransferRequest::class, function (Faker $faker) {
    $Client = Client::where('mobile', '97149474')->first();
    $ClientAyersAccount08 = $Client->AyersAccounts()->orderBy('account_no', 'asc')->first();
    $ClientAyersAccount13 = $Client->AyersAccounts()->orderBy('account_no', 'desc')->first();
    return [
        'uuid' => $Client->uuid,
        'account_out' => $ClientAyersAccount08->account_no,
        'account_in' => $ClientAyersAccount13->account_no,
        'amount' => mt_rand(1, 100) * 1000,
        'status' => 'pending',
        'transfer_time' => Carbon::now()->toDatetimeString(),
        'timezone' => 8,
    ];
});
