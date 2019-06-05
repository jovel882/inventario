<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->company,
    ];
});
