<?php

use Faker\Generator as Faker;

$factory->define(App\TipoConsulta::class, function (Faker $faker) {
    return [
        'tipo' => $faker->company,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
    ];
});
