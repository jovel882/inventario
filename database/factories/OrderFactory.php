<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'date' => $faker->dateTimeBetween('now', '+5 years', null),        
    ];
});
