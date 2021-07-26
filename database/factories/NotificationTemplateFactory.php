<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\NotificationTemplate;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(NotificationTemplate::class, function (Faker $faker) {
    return [
        'name' => '中籤通知'.Str::random(3),
        'template' => $faker->paragraph
    ];
});
