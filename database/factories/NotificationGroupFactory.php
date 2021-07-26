<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\NotificationGroup;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(NotificationGroup::class, function (Faker $faker) {
    $route = ['sms','email','account_overview'];
    return [
        'route' => $route[$faker->unique(true)->numberBetween(0,2)],
        'notification_template_id' => null,
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'issued_by' => 'anderson',
    ];
});
