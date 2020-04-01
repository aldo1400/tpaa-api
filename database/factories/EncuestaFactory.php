<?php

use App\Periodo;
use App\Encuesta;
use Faker\Generator as Faker;

$factory->define(Encuesta::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'descripcion' => $faker->company,
        'fecha_inicio' => $faker->dateTime($max = 'now', $timezone = null),
        'fecha_fin' => $faker->dateTime($max = 'now', $timezone = null),
        'encuesta_facil_id' => 4545,
        'periodo_id' => function () {
            return factory(Periodo::class)->create()->id;
        },
    ];
});
