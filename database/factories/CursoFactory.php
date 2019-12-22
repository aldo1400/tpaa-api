<?php

use Faker\Generator as Faker;

$factory->define(App\Curso::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'interno' => $faker->randomElement([
            0,
            1,
        ]),
    ];
});
