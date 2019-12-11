<?php

use App\Cargo;
use Faker\Generator as Faker;

$factory->define(App\Cargo::class, function (Faker $faker) {
    return [
        'nivel_jerarquico' => $faker->randomElement([
                                Cargo::ESTRATEGICO_TACTICO,
                                Cargo::OPERATIVO_SUPERVISIÓN,
                                Cargo::TACTICO_OPERATIVO,
                                Cargo::TACTICO,
                                Cargo::EJECUCION,
                            ]),
        'nombre' => $faker->company,
    ];
});
