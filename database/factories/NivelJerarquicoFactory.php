<?php

use Faker\Generator as Faker;

$factory->define(App\NivelJerarquico::class, function (Faker $faker) {
    return [
        'nivel_nombre' => $faker->company,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
    ];
});
