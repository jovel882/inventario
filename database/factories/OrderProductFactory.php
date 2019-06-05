<?php

use Faker\Generator as Faker;

$factory->define(App\Models\OrderProduct::class, function (Faker $faker) {
    $quantity=$faker->numberBetween(1,100);
    return [
        'order_id' => 1,
        'product_id' => 1,
        'quantity' => $quantity,
        'quantity_available' => $quantity,
        'lote' => $faker->ean8,
        'expiry_date' => $faker->dateTimeBetween('now', '+5 years', null),
        'price' => $faker->randomFloat(2, 100),
    ];
});
