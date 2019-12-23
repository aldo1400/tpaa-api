<?php

use Faker\Generator as Faker;

$factory->define(App\Curso::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'tipo' => $faker->randomElement([
            0,
            1,
        ]),
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
    ];
});
