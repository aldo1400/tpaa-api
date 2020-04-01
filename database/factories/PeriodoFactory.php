<?php

use App\Periodo;
use App\EncuestaPlantilla;
use Faker\Generator as Faker;

$factory->define(Periodo::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'year' => $faker->year($max = 'now'),
        'detalle' => $faker->company,
        'descripcion' => $faker->company,
        'encuesta_plantilla_id' => function () {
            return factory(EncuestaPlantilla::class)->create()->id;
        },
    ];
});
