<?php

use Faker\Generator as Faker;

$factory->define(App\TipoArea::class, function (Faker $faker) {
    return [
        'tipo_nombre' => $faker->company,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
    ];
});
