<?php

use App\Encuesta;
use App\EncuestaPlantilla;
use Faker\Generator as Faker;

$factory->define(Encuesta::class, function (Faker $faker) {
    return [
        'periodo' => $faker->company,
        'descripcion' => $faker->company,
        'fecha_inicio' => $faker->dateTime($max = 'now', $timezone = null),
        'fecha_fin' => $faker->dateTime($max = 'now', $timezone = null),
        'encuesta_facil_id' => 4545,
        'encuesta_plantilla_id' => function () {
            return factory(EncuestaPlantilla::class)->create()->id;
        },
    ];
});
