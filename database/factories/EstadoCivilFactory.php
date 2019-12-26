<?php

use App\EstadoCivil;
use Faker\Generator as Faker;

$factory->define(EstadoCivil::class, function (Faker $faker) {
    return [
        'tipo' => $faker->company,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
    ];
});

$factory->state(EstadoCivil::class, 'activo', function (Faker $faker) {
    return [
        'estado' => 1,
    ];
});
