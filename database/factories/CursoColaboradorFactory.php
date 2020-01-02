<?php

use App\Curso;
use App\Colaborador;
use App\CursoColaborador;
use Faker\Generator as Faker;

$factory->define(CursoColaborador::class, function (Faker $faker) {
    return [
        'fecha' => $faker->dateTime($max = 'now', $timezone = null),
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
        'colaborador_id' => function () {
            return factory(Colaborador::class)->create()->id;
        },
        'curso_id' => function () {
            return factory(Curso::class)->create()->id;
        },
    ];
});
