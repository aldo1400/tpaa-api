<?php

use App\Area;
use App\Cargo;
use App\NivelJerarquico;
use Faker\Generator as Faker;

$factory->define(App\Cargo::class, function (Faker $faker) {
    return [
        // 'nivel_jerarquico' => $faker->randomElement([
        //                         Cargo::ESTRATEGICO_TACTICO,
        //                         Cargo::OPERATIVO_SUPERVISIÓN,
        //                         Cargo::TACTICO_OPERATIVO,
        //                         Cargo::TACTICO,
        //                         Cargo::EJECUCION,
        //                     ]),
        'nombre' => $faker->company,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
        'area_id' => function () {
            return factory(Area::class)->create()->id;
        },
        'nivel_jerarquico_id' => function () {
            return factory(NivelJerarquico::class)->create()->id;
        },
    ];
});
