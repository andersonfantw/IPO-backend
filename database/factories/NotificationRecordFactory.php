<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\NotificationRecord;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(NotificationRecord::class, function (Faker $faker) {
    $route = ['sms','email','account_overview'];
    $status = ['success','failure'];
    return [
        'notification_group_id' => 2,
        //'route' => $route[$faker->unique(true)->numberBetween(0,2)],
        'route' => 'sms',
        'notification_template_id' => 1,
        'client_id' => '200'.$faker->unique(true)->numberBetween(100,110),
        'name' => $faker->name,
        'phone' => '5598'.$faker->unique()->numberBetween(1000,9999),
        'email' => $faker->unique()->safeEmail,
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'issued_by' => 'anderson',
        'status' => $status[$faker->unique(true)->numberBetween(0,1)],
        'queue_time' => $faker->datetimeThisYear,
        'sending_time' => $faker->datetimeThisYear,
    ];
});
