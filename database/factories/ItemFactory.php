<?php

use Faker\Generator as Faker;

$factory->define(App\Item::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'price' => 10.5,
        'quantity' => $faker->randomDigit(),
        'img_src' => 'shirt.jpg',
        'attributes' => ['size'=>'Large', 'color'=>'Blue'],
        'category' => 'shirt',
        'description' => 'This is a description'
    ];
});
