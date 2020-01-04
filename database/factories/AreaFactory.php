<?php

use App\Area;
use App\TipoArea;
use Faker\Generator as Faker;

$factory->define(Area::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
        'tipo_area_id' => function () {
            return factory(TipoArea::class)->create()->id;
        },
    ];
});
