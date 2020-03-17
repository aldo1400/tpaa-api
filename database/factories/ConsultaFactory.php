<?php

use App\Colaborador;
use App\TipoConsulta;
use Faker\Generator as Faker;

$factory->define(App\Consulta::class, function (Faker $faker) {
    return [
        'texto' => $faker->company,
        'tipo_consulta_id' => function () {
            return factory(TipoConsulta::class)->create()->id;
        },
        'colaborador_id' => function () {
            return factory(Colaborador::class)->create()->id;
        },
    ];
});
