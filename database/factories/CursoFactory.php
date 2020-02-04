<?php

use App\TipoCurso;
use Faker\Generator as Faker;

$factory->define(App\Curso::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'titulo'=>$faker->company,
        'horas_cronologicas'=>$faker->numberBetween($min = 10, $max = 100),
        'realizado'=>$faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'fecha_inicio' => $faker->dateTime($max = 'now', $timezone = null),
        'fecha_termino' => $faker->dateTime($max = 'now', $timezone = null),
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
        'interno' => $faker->randomElement([
            0,
            1,
        ]),
        'anio'=>$faker->year($max = 'now'),
        'tipo_curso_id' => function () {
            return factory(TipoCurso::class)->create()->id;
        },
    ];
});
