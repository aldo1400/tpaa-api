<?php

use Faker\Generator as Faker;

$factory->define(App\NivelEducacion::class, function (Faker $faker) {
    return [
        'nivel_tipo' => $faker->company,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
    ];
});
