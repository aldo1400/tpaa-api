<?php

use App\NivelEducacion;
use Faker\Generator as Faker;

$factory->define(NivelEducacion::class, function (Faker $faker) {
    return [
        'nivel_tipo' => $faker->company,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
    ];
});

$factory->state(NivelEducacion::class, 'activo', function (Faker $faker) {
    return [
        'estado' => 1,
    ];
});
