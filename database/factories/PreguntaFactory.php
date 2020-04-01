<?php

use App\Pregunta;
use App\EncuestaPlantilla;
use Faker\Generator as Faker;

$factory->define(Pregunta::class, function (Faker $faker) {
    return [
        'pregunta' => $faker->company,
        'tipo' => $faker->randomElement([
            Pregunta::ALTERNATIVA, Pregunta::CERRADA, Pregunta::ABIERTA,
        ]),
        'item' => $faker->company,
        'encuesta_plantilla_id' => function () {
            return factory(EncuestaPlantilla::class)->create()->id;
        },
    ];
});
