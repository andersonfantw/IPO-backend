<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ViewClient;
use Carbon\Carbon;
use App\Models\ClientFundInternalTransferRequest;
use Faker\Generator as Faker;

$factory->define(ClientFundInternalTransferRequest::class, function (Faker $faker) {
    $row = ViewClient::where('mobile','=','55984928')->first();
    $rowClientAyersAccount08 = $row->ClientAyersAccount()->orderBy('account_no')->first();
    $rowClientAyersAccount13 = $row->ClientAyersAccount()->orderByDesc('account_no')->first();
    return [
        'uuid' => $row->uuid,
        'account_out' => $rowClientAyersAccount08->account_no,
        'account_in' => $rowClientAyersAccount13->account_no,
        'amount' => mt_rand(1,100)*1000,
        'status' => 'pending',
        'transfer_time' => Carbon::now()->toDatetimeString(),
        'timezone' => 8
    ];
});
