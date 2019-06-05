<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Invoice::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'total' => $faker->randomFloat(2, 100),
        'date' => $faker->dateTimeBetween('now', '+5 years', null),
    ];
});
