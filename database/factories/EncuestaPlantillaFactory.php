<?php

use App\EncuestaPlantilla;
use Faker\Generator as Faker;

$factory->define(EncuestaPlantilla::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'evaluacion' => $faker->randomElement([
            EncuestaPlantilla::TOP, EncuestaPlantilla::DOWN,
        ]),
        'descripcion' => $faker->company,
        'tipo_puntaje' => $faker->randomElement([
            EncuestaPlantilla::PRIMER, EncuestaPlantilla::SEGUNDO,
        ]),
        'tiene_item' => $faker->numberBetween($min = 1, $max = 90),
        'numero_preguntas' => $faker->numberBetween($min = 1, $max = 90),
    ];
});
